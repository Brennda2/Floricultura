<?php

namespace Loja\Floricultura;

abstract class Suprimento extends Produto{
    protected bool $ehOrganico;
    protected \DateTime $validade;
    protected bool $ehLiquido;
    protected string $fabricante;
    protected bool $ehInflamavel;
        
    public function __construct(string $nome, int $quantidade, float $preco, bool $ehOrganico, \DateTime $validade, bool $ehLiquido, string $fabricante, bool $ehInflamavel){
        
        parent::__construct($nome, $quantidade, $preco);
        
        $this->setEhOrganico($ehOrganico);
        $this->setValidade( $validade);
        $this->setEhLiquido($ehLiquido);
        $this->setFabricante($fabricante);
        $this->setEhInflamavel($ehInflamavel);

    }

    public function setEhOrganico(bool $ehOrganico): void {
        $this->ehOrganico = $ehOrganico;
    }
    public function getEhOrganico(): bool {
        return $this->ehOrganico;
    }
    public function setValidade(\DateTime $validade): void {
        $this->validade = $validade;
    }
    public function getValidade(): \DateTime {
        return $this->validade;
    }
    public function setEhLiquido(bool $ehLiquido): void {
        $this->ehLiquido = $ehLiquido;
    }
    public function getEhLiquido(): bool {
        return $this->ehLiquido;
    }
    public function setFabricante(string $fabricante): void {
        $this->fabricante = $fabricante;
    }
    public function getFabricante(): string {
        return $this->fabricante;
    }
    public function setEhInflamavel(bool $ehInflamavel): void {
        $this->ehInflamavel = $ehInflamavel;
    }
    public function getEhInflamavel(): bool {
        return $this->ehInflamavel;
    }

    public function verificarValidade(): bool {
        $hoje = new \DateTime("now");
        $hoje->setTime(0, 0, 0);
        $validade = clone $this->validade;
        $validade->setTime(0, 0, 0);
        
        if ($validade < $hoje) {
            echo "Produto vencido (" . $this->validade->format('d/m/Y') . ")\n";
            return false;
        } else {
            echo "Dentro da validade (" . $this->validade->format('d/m/Y') . ")\n";
            return true;
        }
    }

    public function aplicar(): void {

        echo "Instruções De Aplicação: " .  $this->getNome() . "\n";
        echo "--------------------------------------------------------\n";

        if ($this->getEhInflamavel()) {
            echo "MUITO CUIDADO: Este produto é INFLAMÁVEL.\n";
            echo "Mantenha longe de fontes de calor, faíscas ou chamas abertas.\n";
        } else {
            echo "SEGURANÇA: Produto não inflamável sob condições normais de uso.\n";
        }
        
        if ($this->getEhOrganico()) {
            echo "Composição Orgânico:\n";
            echo "Produto seguro e ecologicamente amigável. Ideal para horta e uso imediato. Não há restrição de contato direto após a aplicação.\n";
        } else {
            echo "Composição Químico:\n";
            echo "O produto é concentrado. Use luvas para manuseio. Evite contato direto com folhas ou raízes se não estiver diluído. Regue a planta após a aplicação.\n";
        }

        echo "\n";
    }

    public function calcularPreco(): float{
        return parent::calcularPreco() + 10.0;
    }
    public function exibirDetalhes(): void {
    
    parent::exibirDetalhes(); 

    echo "Fabricante: " . $this->getFabricante() . "É Orgânico? " . ($this->getEhOrganico() ? "Sim" : "Não") . " |  É Líquido? " . ($this->getEhLiquido() ? "Sim" : "Não") . "\n";
    echo "É Inflamável? " . ($this->getEhInflamavel() ? "Sim" : "Não") . " | Validade: " . $this->getValidade()->format('d/m/Y') . "\n";
}

}