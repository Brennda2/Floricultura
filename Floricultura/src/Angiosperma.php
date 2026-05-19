<?php

namespace Loja\Floricultura;

use Loja\Floricultura\PlantaVascular;

class Angiosperma extends PlantaVascular {
    private bool $possuiFruto;
    private string $nomeDoFruto;
    private string $corDaFlor;
    private bool $frutoComestivel;

    public function __construct(string $nome, int $quantidade, float $preco, string $familia, float $altura, array $necessidadesDaPlanta, 
        string $tipoDeRaiz, float $tamanhoDaRaiz, string $tipoDeCaule, string $corDoCaule, string $tipoDeFolha, float $tamanhoDaFolha, string $corDaFolha, 
        bool $possuiFruto, string $nomeDoFruto, string $corDaFlor, bool $frutoComestivel) {
        
        parent::__construct($nome, $quantidade, $preco, $familia, $altura, $necessidadesDaPlanta, $tipoDeRaiz, $tamanhoDaRaiz, $tipoDeCaule, 
        $corDoCaule, $tipoDeFolha, $tamanhoDaFolha, $corDaFolha);

        $this->setPossuiFruto($possuiFruto);
        $this->setNomeDoFruto($nomeDoFruto);
        $this->setCorDaFlor($corDaFlor);
        $this->setFrutoComestivel($frutoComestivel);
    }

    public function setPossuiFruto(bool $possuiFruto): void {
        $this->possuiFruto = $possuiFruto;
    }
    public function getPossuiFruto(): bool {
        return $this->possuiFruto;
    }

    public function setNomeDoFruto(string $nomeDoFruto): void {
        $this->nomeDoFruto = $nomeDoFruto;
    }
    public function getNomeDoFruto(): string {
        return $this->nomeDoFruto;
    }

    public function setCorDaFlor(string $corDaFlor): void {
        $this->corDaFlor = $corDaFlor;
    }
    public function getCorDaFlor(): string {
        return $this->corDaFlor;
    }
    
    public function setFrutoComestivel(bool $frutoComestivel): void {
        $this->frutoComestivel = $frutoComestivel;
    }
    public function getFrutoComestivel(): bool {
        return $this->frutoComestivel;
    }

    public function exibirDetalhes(): void {
        
        parent::exibirDetalhes();

        echo("Cor da Flor: " . $this->getCorDaFlor() . "\n");
        echo("Possui Fruto: " . ($this->getPossuiFruto() ? "Sim" : "Não") . "\n");
        if ($this->getPossuiFruto()) {
            echo("Nome do Fruto: " . $this->getNomeDoFruto() . " |  Fruto Comestível: " . ($this->getFrutoComestivel() ? "Sim" : "Não") . "\n");
        } else {
            echo "Produz Fruto: Não\n";
        }
    } 

    public function calcularPreco(): float {
        $taxaTipo = 12.50;
        $valorFinal = parent::calcularPreco() + $taxaTipo;
        return $valorFinal;
    }

    private function florescer(): bool {
        echo "A Planta " . $this->getNome() . " com a flor da cor " . $this->getCorDaFlor() . " está florescendo.\n";
        return true;
    }

    public function produzirFruto(): void {
        if ($this->possuiFruto) {
            echo "A planta " . $this->getNome() . " está produzindo o fruto " . $this->getNomeDoFruto() . ".\n";
        } else {
            echo "A planta " . $this->getNome() . " não produz frutos.\n";
        }
    }
    public function atrairPolinizadores(): void {
        if ($this->florescer()) {
            echo "E por estar em floração, a planta " . $this->getNome() . " conseguiu atrair polinizadores.\n";
        } else {
            echo "A planta " . $this->getNome() . " não atraiu polinizadores porque não floresceu.\n";
        }
    }
    
    public function exibirMetodos(): void {
        $this->fazerFotossíntese();
        $this->respirar();
        $this->crescer();
        $this->absorverNutrientesDoSolo();
        $this->produzirFruto();
        $this->atrairPolinizadores();
    }
}