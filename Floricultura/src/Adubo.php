<?php

namespace Loja\Floricultura;

use Loja\Floricultura\Suprimento;

class Adubo extends Suprimento {
    private string $tipoDeAdubo;
    private array  $composicao;
    private string $usoRecomendado;

    public function __construct(string $nome, int $quantidade, float $preco, bool $ehOrganico, \DateTime $validade, bool $ehLiquido, string $fabricante, 
        string $tipoDeAdubo, array $composicao, string $usoRecomendado, bool $ehInflamavel){

        parent::__construct($nome, $quantidade, $preco, $ehOrganico, $validade, $ehLiquido, $fabricante, $ehInflamavel);
        
        $this->setTipoDeAdubo($tipoDeAdubo);
        $this->setComposicao($composicao);
        $this->setUsoRecomendado($usoRecomendado);
    }

    public function setTipoDeAdubo(string $tipoDeAdubo): void {
        $this->tipoDeAdubo = $tipoDeAdubo;
    }

    public function getTipoDeAdubo(): string {
        return $this->tipoDeAdubo;
    }
    public function setComposicao(array $composicao): void {
        $this->composicao = $composicao;
    }

    public function getComposicao(): array {
        return $this->composicao;
    }

    public function setUsoRecomendado(string $usoRecomendado): void {
        $this->usoRecomendado = $usoRecomendado;
    }

    public function getUsoRecomendado(): string {
        return $this->usoRecomendado;
    }

    public function exibirDetalhes(): void {

        parent::exibirDetalhes();

        echo("Uso recomendado: " . $this->getUsoRecomendado() . " |  Composicao: " . implode(", ", $this->getComposicao()) . "\n");
        echo("Tipo de adubo: " . $this->getTipoDeAdubo() . "\n");
    } 

    public function calcularPreco(): float {
        if ($this->getEhOrganico()) {
            return parent::calcularPreco() * 1.10;
        }
        return parent::calcularPreco(); 
    }

    public function aplicar(): void {
        parent::aplicar();
    
        if ($this->getEhLiquido()) {
            echo "Forma Líquida:\n";
            echo "Dilua na água de rega. Aplique diretamente no solo (raiz) a cada 7 ou 15 dias, conforme a necessidade da planta.\n";
        } else {
            echo "Forma Sólida/Granulada:\n";
            echo "Espalhe o adubo em um anel ao redor da planta, longe do caule principal, e regue bem em seguida para dissolver os grânulos.\n";
        }
    
        echo "Uso Recomendado:\n";
        echo "Instrução do Fabricante:" . $this->getUsoRecomendado() . "\n";
        
        echo "--------------------------------------------------------\n";
        echo "Adubação concluída! Sua planta está nutrida e pronta para crescer!\n\n";
    
    }
    
    public function exibirMetodos(): void {
        if(!$this->verificarValidade()){ 
            echo"É arriscado aplicar o produto (está vencido)\n";
            return;
        }
        $this->aplicar();
    }
}