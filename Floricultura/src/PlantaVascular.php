<?php

namespace Loja\Floricultura;

use Loja\Floricultura\Planta;

abstract class PlantaVascular extends Planta {
    protected string $tipoDeRaiz;
    protected float $tamanhoDaRaiz;
    protected string $tipoDeCaule;
    protected string $corDoCaule;
    protected string $tipoDeFolha;
    protected float $tamanhoDaFolha;
    protected string $corDaFolha;
    
    public function __construct(string $nome, int $quantidade, float $preco, string $familia, float $altura, array $necessidadesDaPlanta, string $tipoDeRaiz, 
        float $tamanhoDaRaiz, string $tipoDeCaule, string $corDoCaule, string $tipoDeFolha, float $tamanhoDaFolha, string $corDaFolha) {
        
        parent::__construct($nome, $quantidade, $preco, $familia, $altura, $necessidadesDaPlanta);

        $this->setTipoDeRaiz($tipoDeRaiz);
        $this->setTamanhoDaRaiz($tamanhoDaRaiz);
        $this->setTipoDeCaule($tipoDeCaule);
        $this->setCorDoCaule($corDoCaule);
        $this->setTipoDeFolha($tipoDeFolha);
        $this->setTamanhoDaFolha($tamanhoDaFolha);
        $this->setCorDaFolha($corDaFolha);
    }

    public function calcularPreco(): float{
        return parent::calcularPreco() + 2.0;
    }

    public function setTipoDeRaiz(string $tipoDeRaiz): void {
        $this->tipoDeRaiz = $tipoDeRaiz;
    }

    public function getTipoDeRaiz(): string {
        return $this->tipoDeRaiz;
    }

    public function setTamanhoDaRaiz(float $tamanhoDaRaiz): void {
        $this->tamanhoDaRaiz = $tamanhoDaRaiz;
    }

    public function getTamanhoDaRaiz(): float {
        return $this->tamanhoDaRaiz;
    }

    public function setTipoDeCaule(string $tipoDeCaule): void {
        $this->tipoDeCaule = $tipoDeCaule;
    }

    public function getTipoDeCaule(): string {
        return $this->tipoDeCaule;
    }

    public function setCorDoCaule(string $corDoCaule): void {
        $this->corDoCaule = $corDoCaule;
    }

    public function getCorDoCaule(): string {
        return $this->corDoCaule;
    }

    public function setTipoDeFolha(string $tipoDeFolha): void {
        $this->tipoDeFolha = $tipoDeFolha;
    }

    public function getTipoDeFolha(): string {
        return $this->tipoDeFolha;
    }

    public function setTamanhoDaFolha(float $tamanhoDaFolha): void {
        $this->tamanhoDaFolha = $tamanhoDaFolha;
    }

    public function getTamanhoDaFolha(): float {
        return $this->tamanhoDaFolha;
    }

    public function setCorDaFolha(string $corDaFolha): void {
        $this->corDaFolha = $corDaFolha;
    }

    public function getCorDaFolha(): string {
        return $this->corDaFolha;
    }

    public function exibirDetalhes(): void {

    parent::exibirDetalhes(); 
    
    echo("Tipo de Raiz: " . $this->getTipoDeRaiz() . " |  Cor do Caule: " . $this->getCorDoCaule() . "\n");
    echo("Tamanho da Raiz: " . $this->getTamanhoDaRaiz() . " |  Tipo de Folha: " . $this->getTipoDeFolha() . "\n");     
    echo("Tipo Caule: " . $this->getTipoDeCaule() . " |  Tamanho da Folha: " . $this->getTamanhoDaFolha() . "\n");
    echo("Cor da Folha: " . $this->getCorDaFolha() . "\n");
}
}