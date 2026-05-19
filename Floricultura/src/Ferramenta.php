<?php

namespace Loja\Floricultura;

use Loja\Floricultura\Produto;

class Ferramenta extends Produto {
    private string $tipoDeFerramenta;
    private bool $ehManual;
    private string $material;
    private string $usoRecomendado;

    public function __construct(string $nome, int $quantidade, float $preco, 
        string $tipoDeFerramenta, bool $ehManual, string $material, string $usoRecomendado) {
        
        parent::__construct($nome, $quantidade, $preco);

        $this->setTipoDeFerramenta($tipoDeFerramenta);
        $this->setEhManual($ehManual);
        $this->setMaterial($material);
        $this->setUsoRecomendado($usoRecomendado);
    }

    public function setTipoDeFerramenta(string $tipoDeFerramenta): void {
        $this->tipoDeFerramenta = $tipoDeFerramenta;
    }

    public function getTipoDeFerramenta(): string {
        return $this->tipoDeFerramenta;
    }

    public function setEhManual(bool $ehManual): void {
        $this->ehManual = $ehManual;
    }

    public function getEhManual(): bool {
        return $this->ehManual;
    }

    public function setMaterial(string $material): void {
        $this->material = $material;
    }

    public function getMaterial(): string {
        return $this->material;
    }

    public function setUsoRecomendado(string $usoRecomendado): void {
        $this->usoRecomendado = $usoRecomendado;
    }

    public function getUsoRecomendado(): string {
        return $this->usoRecomendado;
    }

    public function exibirDetalhes(): void {

        parent::exibirDetalhes();

        echo "Tipo: " . $this->getTipoDeFerramenta() . " | É Manual? " . ($this->getEhManual() ? "Sim" : "Não") . "\n";
        echo "Material: " . $this->getMaterial() . " | Uso Recomendado: " . $this->getUsoRecomendado() . "\n";
    }

    public function calcularPreco(): float {
        $preco = parent::calcularPreco();
        $seguro = 0.0;
        if (!$this->getEhManual()) { 
            $seguro = 100.00;
            $preco += $seguro;
        }
        return $preco;
    }

    public function usarFerramenta(): void {
        if ($this->getEhManual()) { 
            echo "Usando " . $this->getNome() . ": Ferramenta de uso manual, requer força física.\n";
        } else {
            echo "Usando " . $this->getNome() . ": Ferramenta motorizada, use equipamentos de segurança.\n";
        }
        echo "Uso Recomendado: " . $this->getUsoRecomendado() . "\n";
    }

    public function exibirMetodos(): void {
        $this->usarFerramenta();
    }
}