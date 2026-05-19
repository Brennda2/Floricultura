<?php

namespace Loja\Floricultura;

use Loja\Floricultura\Planta;


class Briofita extends Planta { 
    private bool $possuiRizoide;
    private float $tamanhoDaColonia;

    public function __construct(string $nome, int $quantidade, float $preco, string $familia, float $altura, array $necessidadesDaPlanta,
        bool $possuiRizoide, float $tamanhoDaColonia) {
        
        parent::__construct($nome, $quantidade, $preco, $familia, $altura, $necessidadesDaPlanta);

        $this->setPossuiRizoide($possuiRizoide);
        $this->setTamanhoDaColonia($tamanhoDaColonia);
    }

    public function setPossuiRizoide(bool $possuiRizoide): void {
        $this->possuiRizoide = $possuiRizoide;
    }

    public function getPossuiRizoide(): bool {
        return $this->possuiRizoide;
    }

    public function setTamanhoDaColonia(float $tamanhoDaColonia): void {
        $this->tamanhoDaColonia = $tamanhoDaColonia;
    }

    public function getTamanhoDaColonia(): float {
        return $this->tamanhoDaColonia;
    }
    
    public function exibirDetalhes(): void {

        parent::exibirDetalhes();
    
        echo("Possui Rizoide?: " . ($this->getPossuiRizoide() ? "Sim" : "Não") . " |  Tamanho da Colonia: " . $this->getTamanhoDaColonia() . "\n");
    } 

    public function calcularPreco(): float {
        $taxaTipo = 2.0;
        $valorFinal = parent::calcularPreco() + $taxaTipo;
        return $valorFinal;
    }

    public function absorverAgua(): void {
        echo "A Briófita " . $this->getNome() . " está absorvendo água por toda a superfície de seu corpo.\n";
    }

    public function exibirMetodos(): void {
        $this->fazerFotossíntese();
        $this->respirar();
        $this->crescer();
        $this->absorverAgua();
        $this->absorverNutrientesDoSolo();
    }
}