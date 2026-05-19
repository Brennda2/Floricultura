<?php

namespace Loja\Floricultura;

use Loja\Floricultura\PlantaVascular;


class Gimnosperma extends PlantaVascular {
    private string $tipoDeCone;
    private bool $sementeAlada;
    private bool $sementeComestivel;
    private string $corDaSemente;

    public function __construct(string $nome, int $quantidade, float $preco, string $familia, float $altura, array $necessidadesDaPlanta, 
        string $tipoDeRaiz, float $tamanhoDaRaiz, string $tipoDeCaule, string $corDoCaule, string $tipoDeFolha, float $tamanhoDaFolha, string $corDaFolha, 
        string $tipoDeCone, bool $sementeAlada, bool $sementeComestivel, string $corDaSemente) {
        
        parent::__construct($nome, $quantidade, $preco, $familia, $altura, $necessidadesDaPlanta, $tipoDeRaiz, $tamanhoDaRaiz, $tipoDeCaule, 
        $corDoCaule, $tipoDeFolha, $tamanhoDaFolha, $corDaFolha);

        $this->setTipoDeCone($tipoDeCone);
        $this->setSementeAlada($sementeAlada);
        $this->setSementeComestivel($sementeComestivel);
        $this->setCorDaSemente($corDaSemente);
    }

    public function setTipoDeCone(string $tipoDeCone): void {
        $this->tipoDeCone = $tipoDeCone;
    }

    public function getTipoDeCone(): string {
        return $this->tipoDeCone;
    }
    public function setSementeAlada(bool $sementeAlada): void {
        $this->sementeAlada = $sementeAlada;
    }
    public function getSementeAlada(): bool {
        return $this->sementeAlada;
    }
    public function setSementeComestivel(bool $sementeComestivel): void {
        $this->sementeComestivel = $sementeComestivel;
    }
    public function getSementeComestivel(): bool {
        return $this->sementeComestivel;
    }
    public function setCorDaSemente(string $corDaSemente): void {
        $this->corDaSemente = $corDaSemente;
    }
    public function getCorDaSemente(): string {
        return $this->corDaSemente;
    }

    public function exibirDetalhes(): void {

        parent::exibirDetalhes();
    
        echo("Tipo de Cone: " . $this->getTipoDeCone() . " |  Semente Alada: " . ($this->getSementeAlada() ? "Sim" : "Não") . "\n");
        echo("Semente Comestivel? " . ($this->getSementeComestivel() ? "Sim" : "Não") . " |  CorDaSemente: " . $this->getCorDaSemente() . "\n");
    } 

    public function calcularPreco(): float {
        $taxaTipo = 8.0;
        $valorFinal = parent::calcularPreco() + $taxaTipo;
        return $valorFinal;
    }

    public function produzirSemente(): void {
        echo "A planta " . $this->getNome() . " está produzindo sementes nuas no seu cone.\n";
    }

    public function exibirMetodos(): void {
        $this->fazerFotossíntese();
        $this->respirar();
        $this->crescer();
        $this->absorverNutrientesDoSolo();
        $this->produzirSemente();
    }
}