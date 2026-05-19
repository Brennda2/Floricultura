<?php

// Define o strict mode
declare(strict_types=1);

namespace Loja\App;

use Loja\Floricultura\Produto;
use Loja\Floricultura\Planta;
use Loja\Floricultura\Briofita;
use Loja\Floricultura\Pteridofita;
use Loja\Floricultura\Gimnosperma;
use Loja\Floricultura\Angiosperma;
use Loja\Floricultura\Suprimento;
use Loja\Floricultura\Adubo;
use Loja\Floricultura\Inseticida;
use Loja\Floricultura\Ferramenta;
use DateTime;

// Configuração Inicial

date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/vendor/autoload.php';

// Variáveis Globais

$estoque = [];
$listaVisual = [];
$lucroTotal = 0.0;  
$totalVendas = 0.0; 

// Funções de Validação de entrada
function lerString(string $prompt): string
{
    while (true) {
        echo $prompt;
        $input = readline();
        
        if ($input === false || trim($input) === "") {
            echo "Entrada vazia. Por favor, digite algo.\n";
            continue;
        }
        return trim($input);
    }
}

function lerInt(string $prompt, ?int $min = null, ?int $max = null): int
{
    while (true) {
        echo $prompt;
        $input = trim(readline());

        // Verifica se é numérico e se é inteiro
        if (!ctype_digit($input) && !(is_numeric($input) && (int)$input == $input)) {
            echo "Entrada inválida. Por favor, digite apenas números inteiros.\n";
            continue;
        }

        $valor = (int)$input;

        // Validação de Mínimo
        if ($min !== null && $valor < $min) {
            echo "Opção inválida. O valor deve ser no mínimo $min.\n";
            continue;
        }

        // Validação de Máximo
        if ($max !== null && $valor > $max) {
            echo "Opção inválida. O valor deve ser no máximo $max.\n";
            continue;
        }

        return $valor;
    }
}

function lerFloat(string $prompt, ?float $min = null): float
{
    while (true) {
        echo $prompt;
        // Troca vírgula por ponto
        $input = str_replace(',', '.', trim(readline()));

        if (!is_numeric($input) || $input === "") {
            echo "Entrada inválida. Por favor, digite um valor numérico (ex: 10.50).\n";
            continue;
        }

        $valor = (float)$input;

        if ($min !== null && $valor < $min) {
            echo "Valor inválido. Deve ser maior ou igual a $min.\n";
            continue;
        }

        return $valor;
    }
}

function lerBool(string $prompt): bool
{
    while (true) {
        $input = strtolower(lerString($prompt . " (s/n): "));
        if ($input === 's') return true;
        if ($input === 'n') return false;
        
        echo "Resposta inválida. Digite apenas 's' para sim ou 'n' para não.\n";
    }
}

function lerArray(string $prompt): array
{
    $input = lerString($prompt . " (separado por vírgula): ");
    return array_map('trim', explode(',', $input));
}


function exibirMenu(): void
{
    echo "\n===========================================================\n";
    echo "            GERENCIADOR DA FLORICULTURA\n";
    echo "===========================================================\n\n";
    echo "1 - Cadastrar Novo Produto\n";
    echo "2 - Adicionar ao Estoque (Selecionar na Lista)\n";
    echo "3 - Ver Estoque Completo (Exibir Detalhes)\n";
    echo "4 - Vender Produto\n";
    echo "5 - Editar Produto\n";
    echo "6 - Excluir Produto\n";
    echo "7 - Ver Lucro Total da Loja\n";
    echo "8 - Exibir Métodos\n";
    echo "0 - Sair\n";
}

function buscarProdutoPorNome(string $nome): ?Produto
{
    global $estoque;
    foreach ($estoque as $produto) {
        if (strtolower($produto->getNome()) === strtolower($nome)) {
            return $produto;
        }
    }
    return null;
}

function verificarProdutoPorNome(string $nome): bool
{
    return buscarProdutoPorNome($nome) !== null;
}

function listarCategoria(string $titulo, string $classe) {
    global $estoque;
    global $listaVisual;

    $itensCategoria = [];
    foreach ($estoque as $p) {
        if ($p instanceof $classe) {
            $itensCategoria[] = $p;
        }
    }

    if (!empty($itensCategoria)) {
        echo "\n--- $titulo ---\n";
        foreach ($itensCategoria as $p) {
            $listaVisual[] = $p; // Adiciona na lista
            $idVisual = count($listaVisual); 
            echo "[$idVisual] " . $p->getNome() . " (Atual: " . $p->getQuantidade() . " un)\n";
        }
    }
}


function selecionarProdutoPorTipo(): ?Produto
{
    global $estoque;
    global $listaVisual;

    if (empty($estoque)) {
        echo "\nO estoque está vazio. Cadastre algo primeiro!\n";
        return null;
    }

    $listaVisual = [];

    echo "\n================ SELEÇÃO DE PRODUTO ================\n";


    listarCategoria("PLANTAS", Planta::class);
    listarCategoria("SUPRIMENTOS", Suprimento::class);
    listarCategoria("FERRAMENTAS", Ferramenta::class);

    echo "\n====================================================\n";
    
    // Validação dinâmica: só aceita de 0 até o total de itens listados
    $totalItens = count($listaVisual);
    $escolha = lerInt("Digite o NÚMERO do produto (ou 0 para cancelar): ", 0, $totalItens);

    if ($escolha === 0) {
        return null;
    }
    

    return $listaVisual[$escolha - 1];
}

function cadastrarProduto(): void
{
    global $estoque;

    echo "\n--- Cadastrar Novo Produto ---\n";

    $tipoProduto = lerInt("Qual tipo de produto?\n1-Planta | 2-Suprimento | 3-Ferramenta\nOpção: ", 1, 3);

    $nome = lerString("Nome do produto: ");
    if (verificarProdutoPorNome($nome)) {
        echo "ERRO: Já existe um produto com este nome! Use a opção 2 para adicionar estoque.\n";
        return;
    }

    $quantidade = lerInt("Quantidade inicial: ", 0);

    $precoBase = lerFloat("Preço base (custo): R$ ", 0.01);

    $novoProduto = null;

    try {
        switch ($tipoProduto) {
            case 1: // Planta

                $tipoPlanta = lerInt("Tipo de planta?\n1-Briófita | 2-Pteridófita | 3-Gimnosperma | 4-Angiosperma\nOpção: ", 1, 4);
                
                $familia = lerString("Família: ");
                $altura = lerFloat("Altura (em cm): ", 0.1);
                $necessidades = lerArray("Necessidades");

                // Inicializa variáveis
                $tipoDeRaiz = $tipoDeCaule = $corDoCaule = $tipoDeFolha = $corDaFolha = "";
                $tamanhoDaRaiz = $tamanhoDaFolha = 0.0;

                // Plantas vasculares
                if ($tipoPlanta >= 2) {
                    $tipoDeRaiz = lerString("Tipo de raiz: ");
                    $tamanhoDaRaiz = lerFloat("Tamanho da raiz (cm): ", 0.1);
                    $tipoDeCaule = lerString("Tipo de caule: ");
                    $corDoCaule = lerString("Cor do caule: ");
                    $tipoDeFolha = lerString("Tipo de folha: ");
                    $tamanhoDaFolha = lerFloat("Tamanho da folha (cm): ", 0.1);
                    $corDaFolha = lerString("Cor da folha: ");
                }

                switch ($tipoPlanta) {
                    case 1: 
                        $possuiRizoide = lerBool("Possui rizoide?");
                        $tamanhoColonia = lerFloat("Tamanho da colônia (cm): ", 0.1);
                        $novoProduto = new Briofita($nome, $quantidade, $precoBase, $familia, $altura, $necessidades, $possuiRizoide, $tamanhoColonia);
                        break;
                    case 2:
                        $vernacao = lerBool("Vernação Circinada?");
                        $soros = lerBool("Possui Soros?");
                        $novoProduto = new Pteridofita($nome, $quantidade, $precoBase, $familia, $altura, $necessidades, $tipoDeRaiz, $tamanhoDaRaiz, $tipoDeCaule, $corDoCaule, $tipoDeFolha, $tamanhoDaFolha, $corDaFolha, $vernacao, $soros);
                        break;
                    case 3:
                        $tipoCone = lerString("Tipo de cone: ");
                        $sementeAlada = lerBool("Semente Alada?");
                        $sementeComestivel = lerBool("Semente Comestível?");
                        $corSemente = lerString("Cor da semente: ");
                        $novoProduto = new Gimnosperma($nome, $quantidade, $precoBase, $familia, $altura, $necessidades, $tipoDeRaiz, $tamanhoDaRaiz, $tipoDeCaule, $corDoCaule, $tipoDeFolha, $tamanhoDaFolha, $corDaFolha, $tipoCone, $sementeAlada, $sementeComestivel, $corSemente);
                        break;
                    case 4:
                        $possuiFruto = lerBool("Possui fruto?");
                        $nomeFruto = $possuiFruto ? lerString("Nome do fruto: ") : "N/A";
                        $frutoComestivel = $possuiFruto ? lerBool("Fruto é comestível?") : false;
                        $corFlor = lerString("Cor da flor: ");
                        $novoProduto = new Angiosperma($nome, $quantidade, $precoBase, $familia, $altura, $necessidades, $tipoDeRaiz, $tamanhoDaRaiz, $tipoDeCaule, $corDoCaule, $tipoDeFolha, $tamanhoDaFolha, $corDaFolha, $possuiFruto, $nomeFruto, $corFlor, $frutoComestivel);
                        break;
                }
                break;

            case 2: // Suprimento
                $tipoSuprimento = lerInt("Tipo de Suprimento?\n1-Adubo | 2-Inseticida\nOpção: ", 1, 2);
                $ehOrganico = lerBool("É orgânico?");
                
                $formatoEsperado = 'd-m-Y';
                $validade = false;

                while ($validade === false) {

                    $dataStr = lerString("Validade (DD-MM-YYYY): ");
                    $validade = DateTime::createFromFormat($formatoEsperado, $dataStr);

                    if ($validade === false) {
                        echo "Data inválida ou formato incorreto. Por favor, tente denovo (DD-MM-YYYY)\n";
                    } else {
                        $validade->setTime(0, 0, 0); 
                    }
                }
                
                $ehLiquido = lerBool("É líquido?");
                $ehInflamavel = lerBool("É inflamável?");
                $fabricante = lerString("Fabricante: ");

                if ($tipoSuprimento == 1) {
                    $tipoAdubo = lerString("Tipo de adubo: ");
                    $composicao = lerArray("Composição");
                    $usoAdubo = lerString("Uso recomendado: ");
                    $novoProduto = new Adubo($nome, $quantidade, $precoBase, $ehOrganico, $validade, $ehLiquido, $fabricante, $tipoAdubo, $composicao, $usoAdubo, $ehInflamavel);
                } else {
                    $tipoPraga = lerArray("Tipos de praga");
                    $novoProduto = new Inseticida($nome, $quantidade, $precoBase, $ehOrganico, $validade, $ehLiquido, $fabricante, $tipoPraga, $ehInflamavel);
                }
                break;

            case 3: // Ferramenta
                $tipoFerramenta = lerString("Tipo (Pá, Tesoura): ");
                $ehManual = lerBool("É manual?");
                $material = lerString("Material: ");
                $usoFerramenta = lerString("Uso recomendado: ");
                $novoProduto = new Ferramenta($nome, $quantidade, $precoBase, $tipoFerramenta, $ehManual, $material, $usoFerramenta);
                break;
        }

        if ($novoProduto !== null) {
            $estoque[] = $novoProduto;
            echo "\nProduto '" . $novoProduto->getNome() . "' cadastrado com sucesso!\n";
        }

    } catch (\Throwable $e) {
        echo "\nErro fatal ao cadastrar: " . $e->getMessage() . "\n";
    }
}

function adicionarEstoque(): void
{
    echo "\n--- Adicionar ao Estoque ---\n";
    
    $produto = selecionarProdutoPorTipo();
    if ($produto === null) return;

    echo "\nProduto: " . $produto->getNome() . "\n";
    echo "Estoque atual: " . $produto->getQuantidade() . "\n";

    $quantidade = lerInt("Quantidade a adicionar: ", 1);

    $produto->setQuantidade($produto->getQuantidade() + $quantidade);
    echo "Estoque atualizado! Novo total: " . $produto->getQuantidade() . "\n";
}

function verEstoque(): void
{
    global $estoque;

    echo "\n--- Estoque Completo da Loja ---\n";

    if (empty($estoque)) {
        echo "O estoque está vazio.\n";
        return;
    }


    $plantas = []; $suprimentos = []; $ferramentas = [];

    foreach ($estoque as $p) {
        if ($p instanceof Planta) $plantas[] = $p;
        elseif ($p instanceof Suprimento) $suprimentos[] = $p;
        elseif ($p instanceof Ferramenta) $ferramentas[] = $p;
    }

    $exibir = function ($lista, $titulo) {
        if (empty($lista)) return;
        echo "\n---- $titulo ----\n";
        foreach ($lista as $item) {
            echo "----------------------------------------\n";
            $item->exibirDetalhes();
            $preco = method_exists($item, 'calcularPreco') ? $item->calcularPreco() : $item->getPreco();
            echo "Preço de Venda: R$ " . number_format($preco, 2, ',', '.') . "\n";
            echo "Em Estoque: " . $item->getQuantidade() . "\n";
        }
    };

    $exibir($plantas, "PLANTAS");
    $exibir($suprimentos, "SUPRIMENTOS");
    $exibir($ferramentas, "FERRAMENTAS");
}

function selecionarProdutoSimples(): ?Produto
{
    global $estoque;
    
    if (empty($estoque)) {
        echo "\nNenhum produto cadastrado.\n";
        return null;
    }

    echo "\nSelecione o produto:\n";
    foreach ($estoque as $index => $produto) {
        echo ($index + 1) . " - " . $produto->getNome() . " (Qtd: " . $produto->getQuantidade() . ")\n";
    }
    echo "0 - Cancelar\n";


    $escolha = lerInt("Opção: ", 0, count($estoque));
    
    if ($escolha === 0) return null;

    return $estoque[$escolha - 1];
}

function venderProduto(): void
{
    global $lucroTotal, $totalVendas;

    $produto = selecionarProdutoSimples();
    if ($produto === null) return;

    $qtdEstoque = $produto->getQuantidade();
    
    if ($qtdEstoque <= 0) {
        echo "Produto sem estoque!\n";
        return;
    }

    $qtdVender = lerInt("Quantidade a vender (Max: $qtdEstoque): ", 1, $qtdEstoque);

    $produto->setQuantidade($qtdEstoque - $qtdVender);
    
    $precoVenda = method_exists($produto, 'calcularPreco') ? $produto->calcularPreco() : $produto->getPreco();
    $custoProduto = $produto->getPreco();
    
    $valorVendaAtual = $precoVenda * $qtdVender;
    $lucroAtual = ($precoVenda - $custoProduto) * $qtdVender;

    $totalVendas += $valorVendaAtual;
    $lucroTotal += $lucroAtual;

    echo "\nVenda Realizada!\n";
    echo "Total a Pagar: R$ " . number_format($valorVendaAtual, 2, ',', '.') . "\n";
    echo "Lucro da Loja: R$ " . number_format($lucroAtual, 2, ',', '.') . "\n";
}

function editarProduto(): void
{
    $produto = selecionarProdutoSimples();
    if ($produto === null) return;

    echo "Editando '" . $produto->getNome() . "'\n";
    
    echo "Novo Nome (ou enter para manter): ";
    $novoNome = trim(readline());
    if (!empty($novoNome)) $produto->setNome($novoNome);

    echo "Novo preço custo (ou enter para manter): ";
    $novoPrecoStr = trim(readline());
    if (!empty($novoPrecoStr)) {
        $novoPreco = (float)str_replace(',', '.', $novoPrecoStr);
        if ($novoPreco > 0) $produto->setPreco($novoPreco);
        else echo "Preço inválido ignorado.\n";
    }
    
    echo "Produto atualizado!\n";
}

function excluirProduto(): void
{
    global $estoque;
    
    $produto = selecionarProdutoSimples();
    if ($produto === null) return;

    $confirmar = lerBool("Tem certeza que deseja excluir '" . $produto->getNome() . "'?");
    
    if ($confirmar) {
        $index = array_search($produto, $estoque, true);
        if ($index !== false) {
            array_splice($estoque, $index, 1); 
            echo "Produto excluído com sucesso!\n";
        }
    }
}

function lucroDaLoja(): void
{
    global $lucroTotal, $totalVendas;

    echo "\n          RELATÓRIO FINANCEIRO\n";
    echo "------------------------------------------------\n";
    echo "Total Bruto Vendido:   R$ " . number_format($totalVendas, 2, ',', '.') . "\n";
    echo "Lucro Líquido:         R$ " . number_format($lucroTotal, 2, ',', '.') . "\n";
    echo "------------------------------------------------\n";
}

function mostrarMetodos(): void{
    global $estoque;
    if (empty($estoque)) {
        echo "\nO estoque está vazio. Cadastre algo primeiro!\n";
        return;
    }
    $p = selecionarProdutoSimples();
    if($p == NULL){
        return;
    }
    $p->exibirMetodos();

}
//Loop Principal

do {
    exibirMenu();
    
    echo "Escolha uma opção: ";
    $input = trim(readline());

    if (!ctype_digit($input) || $input === "") {
        echo "\nOpção inválida, digite novamente.\n";
        $opcao = -1;
    } else {
        $opcao = (int)$input;
        if ($opcao < 0 || $opcao > 8) {
             echo "\nOpção inválida, digite novamente.\n";
             $opcao = -1;
        }
    }

    if ($opcao !== -1) {
        switch ($opcao) {
            case 1: cadastrarProduto(); break; 
            case 2: adicionarEstoque(); break; 
            case 3: verEstoque(); break;
            case 4: venderProduto(); break;
            case 5: editarProduto(); break;
            case 6: excluirProduto(); break;
            case 7: lucroDaLoja(); break;
            case 8: mostrarMetodos(); break;
            case 0: echo "Programa Encerrado!\n"; break;
        }
    }

    if ($opcao != 0) {
        echo "\nPressione Enter para continuar...";
        readline();
    }

} while ($opcao != 0);