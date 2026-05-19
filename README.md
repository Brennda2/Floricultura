# 🌻 Floricultura

Projeto desenvolvido em grupo na disciplina **Programação Orientada a Objeto com PHP**.
* 👩‍💻 **Brennda Lopes, Github: https://github.com/Brennda2/**
* 👨‍💻 **Bruno Doretto, Github: https://github.com/bdfc-dev/**

### 💻 Passos para Instalação

1.  *Abra a pasta Floricultura com o vscode:*
    certifique-se de ter o php e composer baixados na maquina!!

2.  *Instale as dependências do Composer:*
    utilize no seu terminal o comando:
    *composer install*
    Este comando irá gerar o diretório vendor e o arquivo autoload.php, que é necessário para carregar as classes do namespace Brennda\Floricultura automaticamente.

3.  *Execute o programa:*
    Abra seu terminal ou console e execute o seguinte comando na raiz do projeto:
    *php index.php*

4.  *Interaja com o menu:*
    Após a execução, o menu principal será exibido no console, e você poderá escolher as opções digitando o número correspondente.


### 📚 Estrutura do Projeto:

O sistema foi estruturado utilizando Programação Orientada a Objetos para utilizar em um  gerenciamento de estoque e catalogação de produtos para uma floricultura, desenvolvido em PHP.

*Estrutura de Classes*

    ---> Classes Abstratas:

    1.  Produto: Classe mãe abstrata que define atributos básicos como: nome, quantidade, preco e os métodos utilizando polimorfismo: exibirDetalhes, calcularPreco() e exibirMetodos().

    2.  Planta: classe mãe abstrata que define atributos e métodos comuns de todas as  
    plantas, como nome científico, família, altura e ações como fazerFotossintese() e crescer().

    3.  PlantaVascular: Uma classe abstrata que herda de Planta e adiciona características de plantas vasculares, como a presença de raiz, caule e folhas, além do método transportarSeivaBruta().

    4.  Suprimento.php: Classe Abstrata que herda de Produto que define atributos e métodos como aplicar e verificarValidade que serão utilizados em suas classes filhas Adubo e Inseticida.

    ---> Classes Concretas:

    1.  Ferramenta: Herda de Produto e define atributos basicos como tipoDeFerramenta, ehManual, material, usoRecomendado e métodos como usarFerramenta.

    2.  Angiosperma, Gimnosperma e Pteridofitas herdam de PlantaVascular.

    3.  Briofita herda diretamente de Planta.

    4.  Adubo e Inseticida herdam de Suprimento.


### 🛠 Funcionalidades:

    O sistema opera através de um menu principal no terminal, oferecendo as seguintes opções:

    ---> 1. Cadastrar Produto:

    - Permite registrar um novo produto no sistema. O usuário seleciona o tipo específico de produto e preenche os atributos necessários (nome, preço, características específicas), instanciando a classe correta.

    ---> 2. Adicionar Estoque:

    - Possibilita adicionar unidades a um produto já existente. O usuário seleciona o produto e define a quantidade a ser incrementada ao inventário disponível.

    ---> 3. Ver Estoque:
    
    - Exibe uma listagem geral de todos os produtos cadastrados, mostrando informações essenciais como o nome (ou identificador), a quantidade disponível e o preço unitário.

    ---> 4. Vender Produto: 
    
    - Realiza a operação de venda. O sistema solicita qual produto será vendido e a quantidade desejada, verifica se há estoque suficiente e, em caso positivo, baixa o estoque.

    ---> 5. Editar Produto:
    
    - Permite alterar os dados de um produto já cadastrado (como preço ou nome), garantindo que as informações do sistema possam ser corrigidas ou atualizadas sem precisar excluir e recriar o item.

    ---> 6. Mostrar Detalhes:
    
    - Exibe a ficha técnica completa de um item específico, listando todos os atributos cadastrados, incluindo aqueles herdados das classes mãe e os específicos da classe filha.

    ---> 7. Mostrar Ações/Métodos:
    
    - Demonstra o Polimorfismo na prática. Ao selecionar um produto, o sistema executa seus métodos comportamentais específicos (ações que aquele tipo de objeto realiza), variando a saída de acordo com a classe do objeto.

    ---> 8. Relatório de Lucro:
    
    - Exibe o total arrecadado com as vendas realizadas durante a execução do programa ou o lucro estimado com base no estoque movimentado.

    ---> 0. Sair:
    
    - Encerra a execução do script e do menu interativo.

### 🎲 Funcionalidades/Recursos de POO:

    O projeto aplica os princípios da Programação Orientada a Objetos, sendo eles:

    1. Herança: 
    
    Utilizada para construir a hierarquia botânica e de suprimentos, garantindo que as classes filhas reutilizem o código das classes-pai.

    2. Encapsulamento:

    Garante a proteção e integridade dos dados. Todos os atributos críticos (como preço, quantidade e nome) são definidos com visibilidade restrita ("private" ou "protected"). O acesso e a modificação desses dados ocorrem exclusivamente através de métodos públicos **Getters** e **Setters**, permitindo validações antes de alterar o estado do objeto.

    3. Abstração:

    Utilizado em métodos como calcularPreco(), exibirDetalhes() e aplicar(). Além disso, classes como Produto, Planta e Suprimento são abstratas, servindo como regra obrigatória para que as classes filhas implementem comportamentos específicos.

    2. Polimorfismo:
    
    - Cálculo de Preço ("calcularPreco()"): O método possui implementações distintas em cada classe concreta (Angiosperma, Adubo, Ferramenta), aplicando regras de negócio variadas (como taxas ou seguros específicos) sobre o preço base.
    
    - Comportamento ("exibirMetodos()"):* Ao solicitar que um produto exiba suas ações, cada classe executa sua lógica única (ex: uma planta pode "florescer", enquanto um adubo pode "nutrir o solo"), embora a chamada do método seja a mesma para todos.

