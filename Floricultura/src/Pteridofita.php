<?php

namespace Loja\Floricultura;

use Loja\Floricultura\PlantaVascular;

class Pteridofita extends PlantaVascular {
    private bool $vernacaoCircinada;
    private bool $possuiSoros;

    public function __construct(string $nome, int $quantidade, float $preco, string $familia, float $altura, array $necessidadesDaPlanta, 
        string $tipoDeRaiz, float $tamanhoDaRaiz, string $tipoDeCaule, string $corDoCaule, string $tipoDeFolha, float $tamanhoDaFolha, string $corDaFolha, 
        bool $vernacaoCircinada, bool $possuiSoros) {
        
        parent::__construct($nome, $quantidade, $preco, $familia, $altura, $necessidadesDaPlanta, $tipoDeRaiz, $tamanhoDaRaiz, $tipoDeCaule, 
        $corDoCaule, $tipoDeFolha, $tamanhoDaFolha, $corDaFolha);

        $this->setVernacaoCircinada($vernacaoCircinada);
        $this->setPossuiSoros($possuiSoros);
    }

    public function setVernacaoCircinada(bool $vernacaoCircinada): void {
        $this->vernacaoCircinada= $vernacaoCircinada;
    }

    public function getVernacaoCircinada(): bool {
        return $this->vernacaoCircinada;
    }

    public function setPossuiSoros(bool $possuiSoros): void {
        $this->possuiSoros = $possuiSoros;
    }

    public function getPossuiSoros(): bool {
        return $this->possuiSoros;
    }


    public function exibirDetalhes(): void {

    parent::exibirDetalhes();
    
    echo("Vernação Circinada: " . ($this->getVernacaoCircinada() ? "Sim" : "Não") . "\n");
    echo("Possui Soros? " . ($this->getPossuiSoros() ? "Sim" : "Não") . "\n");
}

    public function calcularPreco(): float {
        $taxaTipo = 5.0;
        $valorFinal = parent::calcularPreco() + $taxaTipo;
        return $valorFinal;
    }

    public function dispersarEsporos(): void {
        if ($this->formarSoros()) {
            echo "E após formar os soros, está dispersando os esporos.\n";
        } else {
            echo "A planta " . $this->getNome() . " ainda não formou os soros e não consegue dispersar seus esporos.\n";
        }
    }

    private function formarSoros(): bool {
        if ($this->possuiSoros){
            echo "A Planta " . $this->getNome() . " Está formando seus soros.\n";
            return true;
        }
        return false;
    }

    public function exibirMetodos(): void {
        $this->fazerFotossíntese();
        $this->respirar();
        $this->crescer();
        $this->absorverNutrientesDoSolo();
        $this->dispersarEsporos();
    }
}