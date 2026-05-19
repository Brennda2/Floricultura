<?php

namespace Loja\Floricultura;

use DateTime;
use Loja\Floricultura\Suprimento;

class Inseticida extends Suprimento {
    private array $tipoPraga;

    public function __construct(string $nome, int $quantidade, float $preco, bool $ehOrganico, DateTime $validade, bool $ehLiquido, string $fabricante, 
        array $tipoPraga, bool $ehInflamavel) {
        
        parent::__construct($nome, $quantidade, $preco, $ehOrganico, $validade, $ehLiquido, $fabricante, $ehInflamavel);
        $this->setTipoPraga($tipoPraga);
    }

    public function setTipoPraga(array $tipoPraga): void {
        $this->tipoPraga = $tipoPraga;
    }

    public function getTipoPraga(): array {
        return $this->tipoPraga;
    }
    
    public function exibirDetalhes(): void {
        
        parent::exibirDetalhes();
        
        echo "Pragas Alvo: " . implode(", ", $this->getTipoPraga()) . "\n";
    }
    
    
    public function calcularPreco(): float {
        if ($this->getEhLiquido()) {
            return parent::calcularPreco() * 1.05;
        }
        return parent::calcularPreco(); 
    }
    
    public function aplicar(): void {
        
        parent::aplicar();
        
        if ($this->getEhLiquido()) {
            echo "Forma Líquida:\n";
            echo "Agite bem antes de usar. Utilize um pulverizador para garantir uma cobertura uniforme da folhagem (frente e verso).\n";
        } else {
            echo "Forma Sólida/Pó:\n";
            echo "Aplique diretamente no solo ou com um polvilhador nas áreas infestadas. Não aplique em dias de vento forte.\n";
        }
        
        echo "--------------------------------------------------------\n";
        echo "Aplicação concluída!!! O ambiente está sendo tratado!\n\n";
    }

    public function exibirMetodos(): void {
        if(!$this->verificarValidade()){
            echo"É arriscado aplicar o produto (está vencido)\n";
            return;
        }
        $this->aplicar();
    }
}