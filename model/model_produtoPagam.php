<?php // Arquivo de modelagem para associação de produtos à despesas

include_once __DIR__ . '/conexao.php'; // Incluir conexão com banco de dados

class ProdutoPagam // Criação da classe para associação com tabela do BD
{
    // Atributos de classe
    private $codProduto;
    private $codPagam;
    private $qntProduto;

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

    // Crud da tabela 'produtoPagam'
    function cadastraProdutoPagam()
    {
        $cadastraSql = "INSERT INTO produtoPagam (codProduto, codPagam, qntProduto) VALUES (?, ?, ?)";
        $valoresCad = array($this->codProduto, $this->codPagam, $this->qntProduto);
        $executa = $this->con->prepare($cadastraSql);
        $executa->execute($valoresCad);
    }

    function consultaProdutoPagam()
    {
        $consultaSql = "SELECT 
                pg.codPagam,
                pg.nomePagam,
                pg.descPagam,
                pg.dataInic,
                pg.dataFim,
                pg.valorPagam,
                GROUP_CONCAT(CONCAT(p.nomeProduto, ': ', ppg.qntProduto) SEPARATOR '<br>') AS produtos
            FROM 
                pagamento pg
            JOIN 
                produtoPagam ppg ON pg.codPagam = ppg.codPagam
            JOIN 
                produto p ON ppg.codProduto = p.codProduto
            WHERE 
                pg.codUsu = ?
            GROUP BY 
                pg.codPagam
            ORDER BY 
                pg.codPagam";
        $codUsuario = array($_SESSION["codUsu"]); // É necessário que seja uma array armazenando os valores
        $executa = $this->con->prepare($consultaSql);
        $executa->execute($codUsuario);

        $produtosPagam = array(); // Variável que armazena resultados
        foreach ($executa->fetchAll() as $valor)
        {
            $produtosPagam[] = [
                "codPagam" => $valor['codPagam'],
                "nomePagam" => $valor['nomePagam'],
                "descPagam" => $valor['descPagam'],
                "produtos" => $valor['produtos'],
                "dataInicio" => $valor['dataInic'],
                "dataFim" => $valor['dataFim'],
                "valorPagam" => $valor['valorPagam'],
            ];
        }
        return $produtosPagam;
    }
}


?>