<?php

namespace Loja\Floricultura;

abstract Class Produto {
    private string $nome;
    private int $quantidade;
    private float $preco;

    public function __construct(string $nome, int $quantidade, float $preco) {
        $this->setNome($nome);
        $this->setQuantidade($quantidade);
        $this->setPreco($preco);
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setQuantidade(int $quantidade): void {
        $this->quantidade = $quantidade;
    }

    public function getQuantidade(): int {
        return $this->quantidade;
    }
    public function setPreco(float $preco): void {
        $this->preco = $preco;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function exibirDetalhes(): void { 
    echo "===========================================\n";
    echo "  DETALHES DO PRODUTO \n";
    echo "===========================================\n";
    echo "Nome: " . $this->getNome() . " | Quantidade: " . $this->getQuantidade() . "\n";
    echo "Preço: R$ " . number_format($this->getPreco(), 2, ',', '.') . "\n";
}

    abstract public function exibirMetodos(): void;
    public function calcularPreco(): float{
        return $this->getPreco();
    }
}