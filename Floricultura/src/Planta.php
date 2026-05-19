<?php

namespace Loja\Floricultura;

use Loja\Floricultura\Produto;

abstract class Planta extends Produto {
    protected string $familia;
    protected float $altura;
    protected array $necessidadesDaPlanta = [];
    
    public function __construct(string $nome, int $quantidade, float $preco, string $familia, float $altura, array $necessidadesDaPlanta) {
        
        parent::__construct($nome, $quantidade, $preco);

        $this->setFamilia($familia);
        $this->setAltura($altura);
        $this->setNecessidadesDaPlanta($necessidadesDaPlanta);
    }

    public function setFamilia(string $familia): void {
        $this->familia = $familia;
    }

    public function getFamilia(): string {
        return $this->familia;
    }

    public function setAltura(float $altura): void {
        $this->altura = $altura;
    }

    public function getAltura(): float {
        return $this->altura;
    }

    public function setNecessidadesDaPlanta(array $necessidades): void {
        $this->necessidadesDaPlanta = $necessidades;
    }

    public function getNecessidadesDaPlanta(): array {
        return $this->necessidadesDaPlanta;
    }
    
    protected function calcularTaxaAltura(): float {
        if ($this->getAltura() <= 35) {
            return 0.0;
        } elseif ($this->getAltura() <= 70) {
            return ($this->getAltura() / 10) * 0.10;
        } else {
            return ($this->getAltura() / 10) * 0.12;
        }
    }

    public function portePlanta(): string {
        if ($this->getAltura() <= 35) { 
            return "Essa Planta é de Pequeno Porte";
        } elseif ($this->getAltura() <= 70) {
            return "Essa Planta é de Médio Porte";
        } else {
            return "Essa Planta é de Grande Porte";
        }
    }

    public function calcularPreco(): float{
        $preco = parent::calcularPreco() + $this->calcularTaxaAltura();
        return $preco;
    }

    public function fazerFotossíntese(): void {
        echo ("A planta " . $this->getNome() .  " está recebendo luz solar e fazendo fotossintese.\n");
    }
    
    public function respirar(): void {
        echo ("A planta " . $this->getNome() . " abriu os estomatos e está realizando trocas gasosas.\n");
    }

    public function crescer(): void {
        echo ("A planta " . $this->getNome() .  " cresceu e está com a altura de ". $this->getAltura() . ".\n");
    }

    public function absorverNutrientesDoSolo(): void {
        echo ("A planta " . $this->getNome() . " está absorvendo os nutrientes do solo.\n");
    }

    public function exibirDetalhes(): void {

        parent::exibirDetalhes();

        echo("Familia: " . $this->getFamilia() . " | Altura: " . $this->getAltura() . "\n");
        echo("Necessidade da Planta: " . implode(", ", $this->getNecessidadesDaPlanta()) . "\n");        
    }
}