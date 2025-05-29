<?php // Arquivo de modelagem da integração de produtos ao BD

include 'conexao.php'; // Incluir conexão com baco de dados


class Produto // Criação da classe que referencia à entidade do BD
{
    // Características de classe: Atributos de Produto
    private $codProduto;
    private $nomeProduto;
    private $valorProduto;
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
    
    // Crud da tabela 'produto'
    function cadastraProduto()
    {
        $this->verificaProduto(); // Executa validação
        
        $cadastraSql = "INSERT INTO produto (nomeProduto, valorProduto, codUsu) VALUES (?, ?, ?)";
        $valoresCad = array($this->nomeProduto, $this->valorProduto, $this->codUsuario);
        $executa = $this->con->prepare($cadastraSql);
        $executa->execute($valoresCad);
    }
    
    function consultaProduto()
    {
        $consultaSql = "SELECT * FROM produto WHERE codUsu = ?";
        $valoresCon = array($this->codUsuario);
        $executa = $this->con->prepare($consultaSql);
        $executa->execute($valoresCon);
        
        $produtos = array(); // Variável que armazena resultados
        foreach ($executa->fetchAll() as $valor)
        {
            $produto = new Produto; // Usar atributos de classe
            $produto->nomeProduto = $valor['nomeProduto'];
            $produto->valorProduto = $valor['valorProduto'];
            $produto->codProduto = $valor['codProduto'];
            $produtos[] =[
                "nome" => $produto->nomeProduto,
                "valor" => $produto->valorProduto,
                "cod" => $produto->codProduto
            ];
        }
        return $produtos;
    }

    function atualizaProduto()
    {
        $this->verificaProduto();

        $atualizaSql = "UPDATE produto SET nomeProduto = ?, valorProduto = ? WHERE codProduto = ?";
        $valoresAtu = array($this->nomeProduto, $this->valorProduto, $this->codProduto);
        $executa = $this->con->prepare($atualizaSql);
        $executa->execute($valoresAtu);
    }

    function excluiProduto()
    {
        // Remove as referências na tabela produtoPagam
        $excluiRefSql = "DELETE FROM produtoPagam WHERE codProduto = ?";
        $valoresRef = array($this->codProduto);
        $executaRef = $this->con->prepare($excluiRefSql);
        $executaRef->execute($valoresRef);

        // Por fim, remove o produto
        $excluiSql = "DELETE FROM produto WHERE codProduto = ?";
        $valoresExc = array($this->codProduto);
        $executa = $this->con->prepare($excluiSql);
        $executa->execute($valoresExc);
    }

    function verificaProduto()
    {
        $verificacaoSql = "SELECT COUNT(*) FROM produto WHERE codUsu = ? AND nomeProduto LIKE ? ";
        $valoresVer = array($this->codUsuario, $this->nomeProduto);
        
        if ($this->codProduto) {
            $verificacaoSql .= "AND codProduto != ?";
            $valoresVer[] = $this->codProduto;
        }
        
        $executa = $this->con->prepare($verificacaoSql);
        $executa->execute($valoresVer);
        
        $qtd = $executa->fetchColumn();
        if ($qtd > 0)
        {
            header("Location: produtos.php?erro=existe");
            exit();
        }
    }
}


?>