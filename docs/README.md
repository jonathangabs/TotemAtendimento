# Orientação sobre commits

- Instalação do ambiente no VS Code (caso não tenha o VS Code, realize a instalação).

- O Git é uma aplicação baseada em comandos e não é nativa do Windows nem do VS Code. Sendo assim, é necessária a instalação. Com ele, por meio de comandos e da sua conta do GitHub, é possível realizar uploads e downloads de arquivos.

- Baixe o instalador do Git no link oficial:  
https://git-scm.com/install/windows  

Ou pesquise no navegador (Google): **git instalação** ou **instalar git**.

---

## Passo 1: Baixar e instalar o Git

![Passo 1](_img/img_orientacao_commit/passo_01.png)

**Passo 1 concluído**

---

Após a instalação e com sua conta do GitHub, acesse o repositório do projeto:  
https://github.com/jonathangabs/TotemAtendimento/tree/main  

Abra o VS Code e siga os passos:

---

## Passo 2: Conectar conta no VS Code

Clique em **Conectar à conta**:

![Passo 2](_img/img_orientacao_commit/passo_02.png)

Clique em **Open Remote Repository**:

![Passo 2](_img/img_orientacao_commit/passo_02-1.png)

Confirme para logar e realizar o vínculo:

![Passo 2](_img/img_orientacao_commit/passo_02-2.png)

**Passo 2 concluído**

---

## Passo 3: Copiar link do repositório

Acesse o repositório:  
https://github.com/jonathangabs/TotemAtendimento/tree/main  

Copie o link:

![Passo 3](_img/img_orientacao_commit/passo_03.png)

**Passo 3 concluído**

---

## Passo 4: Abrir nova janela no VS Code

Em **File (Arquivo)** → **New Window (Nova janela)**:

![Passo 4](_img/img_orientacao_commit/passo_04.png)

**Passo 4 concluído**

---

## Passo 5: Clonar repositório

Na aba lateral esquerda, selecione a opção indicada.  
Cole o link copiado do GitHub:

![Passo 5](_img/img_orientacao_commit/passo_05.png)

**Passo 5 concluído**

---

## Passo 6: Criar pasta e salvar repositório

Crie uma pasta (exemplo: `gestao_projeto_carol`)  
e salve o repositório dentro dela:

![Passo 6](_img/img_orientacao_commit/passo_06.png)

Resultado esperado:

![Passo 6](_img/img_orientacao_commit/passo_06-1.png)

**Passo 6 concluído**

---

## Passo 7: Executar comandos Git

Abra o terminal e verifique se está na pasta do projeto:

![Passo 7](_img/img_orientacao_commit/passo_07.png)

**Passo 7 (verificação) concluído**

---

### Comandos:

- Atualizar projeto local:

```bash
git pull
```

- Adicionar arquivos:

```bash
git add .
```

- Criar commit:

```bash
git commit -m ""
```

Exemplo:

```bash
git commit -m "descricao de como realizar os commits_v1 ab#65"
```

- Enviar para o GitHub:

```bash
git push
```

---

### Configuração de credenciais

Usuário não conectado:

![Passo 7 - parte 1](_img/img_orientacao_commit/passo_07-01.png)

Configuração:

![Passo 7 - parte 2](_img/img_orientacao_commit/passo_07-02.png)

```bash
git config --global user.email "you@example.com"
git config --global user.name "Your Name"
```

Após configuração:

![Passo 7 - parte 3](_img/img_orientacao_commit/passo_07-03.png)

Finalização do commit:

![Passo 7 - parte 4](_img/img_orientacao_commit/passo_07-04.png)

**Passo 7 concluído**