<?php // Arquivo de modelagem e integração dos pagamentos ao BD

include_once __DIR__ . '/conexao.php'; // Incluir conexão com banco de dados

class Pagamento // Criação da classe que referencia à entidade do BD
{
    // Características de classe: Atributos de Pagamento
    private $codPagam;
    private $nomePagam;
    private $descPagam;
    private $dataInicio;
    private $dataFim;
    private $periodo;
    private $valorPagam;
    private $codUsuario;

    // Métodos de classe
    function __get($atributo) // Função get mágico recebe nome do atributo de classe
    {
        return $this->$atributo; // Retorna o valor do atributo de classe
    }
    function __set($atributo, $valor) // Função set mágico recebe nome do atributo e valor a aplicar
    {
        $this->$atributo = $valor; // Atribui característica de classe com o valor recebido
    }
    
    private $con; // Chave de acesso para conexão com BD
    function __construct() // Método construtor: Executa sempre que um objeto de classe for instanciado
    {
        $conectar = new Conexao(); // Objeto de conexão ao BD
        $this->con = $conectar->Conectar(); // Executa método de conexão ao BD
    }

    function cadastraPagam()
    {
        $this->verificaPagam();

        $cadastraSql = "INSERT INTO pagamento (nomePagam, descPagam, dataInic, dataFim, periodo, valorPagam, codUsu) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $valoresCad = array($this->nomePagam, $this->descPagam, $this->dataInicio, $this->dataFim, $this->periodo, $this->valorPagam, $this->codUsuario);
        $executa = $this->con->prepare($cadastraSql);
        $executa->execute($valoresCad);

        $idPagam = $this->con->lastInsertId();
        return $idPagam;
    }

    function consultaPagam()
    {
        $consultaSql = "SELECT * FROM pagamento WHERE codUsu = ? AND valorPagam <= 0 ORDER BY dataInic ASC";
        $valoresCad = array($this->codUsuario);
        $executa = $this->con->prepare($consultaSql);
        $executa->execute($valoresCad);
        
        $pagamentos = array(); // Variável que armazena resultados
        foreach ($executa->fetchAll() as $valor)
        {
            $pagam = new Pagamento; // Usar atributos de classe
            $pagam->nomePagam = $valor['nomePagam'];
            $pagam->descPagam = $valor['descPagam'];
            $pagam->dataInicio = $valor['dataInic'];
            $pagam->dataFim = $valor['dataFim'];
            $pagam->periodo = $valor['periodo'];
            $pagam->valorPagam = $valor['valorPagam'];
            $pagam->codPagam = $valor['codPagam'];

            // Tratamento de exibição do período
            if (strripos($pagam->periodo, "days")) // Localiza um conjunto de caracteres
            {
                $pagam->periodo = str_replace("days", "dias", $pagam->periodo); // Substituir caractere para termo em portugês
            }
            elseif (strripos($pagam->periodo, "weeks"))
            {
                $pagam->periodo = str_replace("weeks", "semanas", $pagam->periodo);
            }
            elseif (strripos($pagam->periodo, "months"))
            {
                $pagam->periodo = str_replace("months", "meses", $pagam->periodo);
            }
            elseif (strripos($pagam->periodo, "years"))
            {
                $pagam->periodo = str_replace("years", "anos", $pagam->periodo);
            }

            $pagamentos[] =[
                "nome" => $pagam->nomePagam,
                "desc" => $pagam->descPagam,
                "dataInicio" => $pagam->dataInicio,
                "dataFim" => $pagam->dataFim,
                "periodo" => $pagam->periodo,
                "valor" => $pagam->valorPagam,
                "cod" => $pagam->codPagam
            ];
        }
        return $pagamentos;
    }

    function consultaProdutosPagamento()
    {
        $consultaSql = "SELECT p.codProduto, p.nomeProduto, p.valorProduto, ppg.qntProduto 
                       FROM produtoPagam ppg 
                       JOIN produto p ON ppg.codProduto = p.codProduto 
                       WHERE ppg.codPagam = ?";
        $valoresCon = array($this->codPagam);
        $executa = $this->con->prepare($consultaSql);
        $executa->execute($valoresCon);
        
        $produtos = array();
        foreach ($executa->fetchAll() as $valor) {
            $produtos[] = [
                "codProduto" => $valor['codProduto'],
                "nomeProduto" => $valor['nomeProduto'],
                "valorProduto" => $valor['valorProduto'],
                "qntProduto" => $valor['qntProduto']
            ];
        }
        return $produtos;
    }

    function consultarPagamento()
    {
        $consultaSql = "SELECT * FROM pagamento WHERE codPagam = ?";
        $valoresCon = array($this->codPagam);
        $executa = $this->con->prepare($consultaSql);
        $executa->execute($valoresCon);
        
        $pagamento = $executa->fetch(PDO::FETCH_ASSOC);
        return $pagamento;
    }

    function atualizaPagam()
    {
        // Primeiro atualiza os dados básicos do pagamento
        $atualizaSql = "UPDATE pagamento SET nomePagam = ?, descPagam = ?, dataInic = ?, dataFim = ?, periodo = ?, valorPagam = ? WHERE codPagam = ?";
        $valoresAtu = array($this->nomePagam, $this->descPagam, $this->dataInicio, $this->dataFim, $this->periodo, $this->valorPagam, $this->codPagam);
        $executa = $this->con->prepare($atualizaSql);
        $executa->execute($valoresAtu);

        // Se for um lucro, atualiza os produtos associados
        if (isset($_POST['produtos']) && is_array($_POST['produtos'])) {
            // Remove produtos antigos
            $excluiProdSql = "DELETE FROM produtoPagam WHERE codPagam = ?";
            $valoresExclui = array($this->codPagam);
            $executaExclui = $this->con->prepare($excluiProdSql);
            $executaExclui->execute($valoresExclui);

            // Insere os novos produtos
            foreach ($_POST['produtos'] as $index => $codProduto) {
                if ($_POST['qnt_prod'][$index] > 0) {
                    $insereProdSql = "INSERT INTO produtoPagam (codProduto, codPagam, qntProduto) VALUES (?, ?, ?)";
                    $valoresInsere = array($codProduto, $this->codPagam, $_POST['qnt_prod'][$index]);
                    $executaInsere = $this->con->prepare($insereProdSql);
                    $executaInsere->execute($valoresInsere);
                }
            }
        }
    }

    function excluiPagam()
    {
        $excluiSql = "DELETE FROM produtoPagam WHERE codPagam = ?;
            DELETE FROM pagamento WHERE codPagam = ?";
        $valoresExc = array($this->codPagam, $this->codPagam);
        $executa = $this->con->prepare($excluiSql);
        $executa->execute($valoresExc);
    }

    function verificaPagam() // Função adicional: verifica se há produtos existentes
    {
        // Comando de verificação: Verifica registros iguais no BD do usuário
        $verificacaoSql = "SELECT COUNT(*) FROM pagamento WHERE codUsu = ? AND nomePagam LIKE ? AND dataInic = ?"; // Conta quantidade de registros iguais
        $valoresVer = array($this->codUsuario, '%'.$this->nomePagam.'%', $this->dataInicio);
        $executa = $this->con->prepare($verificacaoSql); // Define e prepara os comandos
        $executa->execute($valoresVer);
        
        $qtd = $executa->fetchColumn(); // Armazena resultado
        if ($qtd > 0) // Condição: Encontrado registros iguais no BD
        {
            // Este usuário já cadastrou este produto
            header("Location: pagamentos.php?erro=existe");
            exit();
        }
    }

}
?>