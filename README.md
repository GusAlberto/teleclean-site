# TeleClean Detail

Site institucional da **TeleClean Detail**, empresa de estetica automotiva em Belo Horizonte. O projeto apresenta os servicos da empresa, diferenciais, comparativos de antes e depois, depoimentos, galeria, perguntas frequentes, formas de contato e uma pagina de consulta de horarios para agendamento.

O site foi construido com PHP, HTML, CSS e JavaScript puro. Nao existe etapa de build, framework de frontend ou gerenciador de pacotes.

## Sumario

- [Tecnologias](#tecnologias)
- [Requisitos](#requisitos)
- [Como executar localmente](#como-executar-localmente)
- [Estrutura do projeto](#estrutura-do-projeto)
- [Paginas e componentes](#paginas-e-componentes)
- [Onde alterar textos e dados da empresa](#onde-alterar-textos-e-dados-da-empresa)
- [Onde trocar imagens e videos](#onde-trocar-imagens-e-videos)
- [Como adicionar uma nova secao](#como-adicionar-uma-nova-secao)
- [Como adicionar um novo servico](#como-adicionar-um-novo-servico)
- [Como adicionar itens a galeria](#como-adicionar-itens-a-galeria)
- [Como adicionar perguntas ao FAQ](#como-adicionar-perguntas-ao-faq)
- [Como alterar cores e tipografia](#como-alterar-cores-e-tipografia)
- [JavaScript e comportamentos](#javascript-e-comportamentos)
- [Agendamento](#agendamento)
- [SEO, redes sociais e favicon](#seo-redes-sociais-e-favicon)
- [Acessibilidade e desempenho](#acessibilidade-e-desempenho)
- [Checklist antes de publicar](#checklist-antes-de-publicar)

## Tecnologias

- PHP para composicao das paginas e leitura dos agendamentos.
- HTML5 semantico.
- CSS responsivo em `assets/css/style.css`.
- JavaScript puro em `assets/js/main.js`.
- GSAP carregado por CDN para o carrossel de servicos.
- Google Fonts e Fontshare para as fontes externas.
- JSON-LD com dados estruturados da empresa.
- Arquivo JSON local para os horarios ocupados.

## Requisitos

- PHP 8 ou superior recomendado.
- Navegador moderno com suporte a CSS Grid, Flexbox e `IntersectionObserver`.
- Conexao com a internet para carregar fontes, GSAP e o mapa incorporado do Google.

## Como executar localmente

Na raiz do projeto, inicie o servidor embutido do PHP:

```bash
php -S localhost:8000
```

Depois, acesse:

- Pagina inicial: `http://localhost:8000/`
- Agenda: `http://localhost:8000/schedule.php`
- API de horarios: `http://localhost:8000/api/appointments.php`

O projeto deve ser servido por HTTP. Abrir `index.php` diretamente pelo explorador de arquivos nao executa o PHP e pode quebrar caminhos absolutos como `/schedule.php`.

## Estrutura do projeto

```text
teleclean_site/
|-- api/
|   `-- appointments.php       # Endpoint GET dos horarios ocupados
|-- assets/
|   |-- css/
|   |   `-- style.css          # Todo o estilo e responsividade
|   |-- img/
|   |   |-- favicon.svg
|   |   |-- placeholder.svg    # Imagem exibida quando outra falha
|   |   `-- ...                # Fotos da hero, servicos e galeria
|   |-- js/
|   |   `-- main.js            # Menu, animacoes, carrossel e FAQ
|   `-- video/
|       `-- hero-detail.mp4    # Video de fundo da hero
|-- data/
|   `-- appointments.json      # Lista de horarios ocupados
|-- includes/
|   |-- head.php               # Metadados, fontes, CSS, scripts e JSON-LD
|   |-- header.php             # Cabecalho, navegacao e WhatsApp flutuante
|   `-- footer.php             # Rodape utilizado pela pagina de agenda
|-- index.php                  # Landing page principal
|-- schedule.php               # Pagina de agenda
|-- robots.txt
|-- sitemap.xml
|-- structure.md
`-- README.md
```


## Paginas e componentes

### `index.php`

Contem a landing page e suas secoes, nesta ordem:

1. Hero (`#inicio`)
2. Servicos (`#servicos`)
3. Diferenciais (`#diferenciais`)
4. Antes e depois (`#antes-depois`)
5. Processo (`#processo`)
6. Depoimentos (`#depoimentos`)
7. Galeria (`#galeria`)
8. FAQ (`#faq`)
9. CTA de orcamento (`#orcamento`)
10. Rodape

No topo do arquivo tambem fica o array PHP `$faqItems`, usado para gerar o FAQ.

### `schedule.php`

Exibe o calendario de disponibilidade. O JavaScript da propria pagina consulta `api/appointments.php`, calcula a ocupacao de cada dia e gera links para o WhatsApp.

### `includes/head.php`

Centraliza:

- `<title>` e meta description;
- URL canonica;
- Open Graph e Twitter Card;
- favicon;
- fontes externas;
- CSS e JavaScript globais;
- GSAP;
- dados estruturados Schema.org da empresa.

Cada pagina define `$pageTitle`, `$pageDescription`, `$canonicalUrl` e `$ogImage` antes de incluir esse arquivo.

### `includes/header.php`

Contem a marca, links do menu desktop, menu mobile e botao flutuante do WhatsApp.

### `includes/footer.php`

Rodape compartilhado atualmente utilizado por `schedule.php`. O rodape da home esta escrito diretamente em `index.php`.

## Onde alterar textos e dados da empresa

| Conteudo | Arquivo | Local aproximado |
|---|---|---|
| Titulo, descricao e textos da home | `index.php` | Dentro de cada `<section>` |
| Perguntas e respostas do FAQ | `index.php` | Array `$faqItems` no inicio de `<main>` |
| Menu e WhatsApp flutuante | `includes/header.php` | Links de navegacao e `.floating-whatsapp` |
| Rodape da home | `index.php` | Final do arquivo |
| Rodape da agenda | `includes/footer.php` | Arquivo completo |
| Telefone, endereco e dados estruturados | `includes/head.php` | Bloco JSON-LD |
| Titulo e metadados de cada pagina | `index.php` e `schedule.php` | Variaveis antes de incluir `head.php` |
| Numero usado pela agenda | `schedule.php` | Constante JavaScript `WA_PHONE` |

Ao trocar telefone, endereco, e-mail ou Instagram, pesquise o valor antigo no projeto inteiro para evitar informacoes divergentes:

```bash
rg "3568-3754|553135683754|teleclean.com.br|Benjamim Flores|teleclean_" .
```

Links do WhatsApp usam o formato:

```text
https://wa.me/553135683754?text=MENSAGEM_CODIFICADA
```

O telefone deve conter apenas codigo do pais, DDD e numero. Para gerar a parte `text`, use `encodeURIComponent` no navegador ou um codificador de URL.

## Onde trocar imagens e videos

As imagens ficam em `assets/img/` e o video da hero em `assets/video/`. E possivel substituir um arquivo mantendo o mesmo nome, ou adicionar outro arquivo e atualizar o caminho no HTML.

### Mapa de midias

| Uso | Arquivo atual | Referencia no codigo | Recomendacao |
|---|---|---|---|
| Favicon | `assets/img/favicon.svg` | `includes/head.php` | SVG simples e legivel em 16 x 16 px |
| Imagem de compartilhamento | `assets/img/og-cover.jpg` | `index.php`, `schedule.php` e `includes/head.php` | 1200 x 630 px |
| Poster da hero | `assets/img/hero-poster.jpg` | `index.php` | Mesmo enquadramento do video |
| Video da hero | `assets/video/hero-detail.mp4` | `index.php` | MP4 otimizado, sem audio necessario |
| Servicos | `assets/img/service-*.jpg` | Carrossel em `index.php` | Proporcao aproximada de 4:3 |
| Antes e depois externo | `before-externo.jpg` e `after-externo.jpg` | `index.php` | Mesmo tamanho e enquadramento |
| Antes e depois interno | `before-interno.jpg` e `after-interno.jpg` | `index.php` | Mesmo tamanho e enquadramento |
| Galeria | `gallery-01.jpg` a `gallery-06.jpg` | `index.php` | Imagens quadradas, idealmente 1080 x 1080 px |
| Fallback | `assets/img/placeholder.svg` | `assets/js/main.js` | Exibido automaticamente em erro de imagem |

Alguns arquivos referenciados podem nao existir ainda em uma instalacao nova. Nesse caso, adicione-os a `assets/img/` ou ajuste o caminho no HTML.

### Substituir uma imagem mantendo o nome

1. Otimize a nova imagem para web.
2. Mantenha a extensao e o nome do arquivo existente.
3. Substitua o arquivo dentro de `assets/img/`.
4. Limpe o cache do navegador ou use recarregamento forcado.
5. Confirme se o texto `alt` ainda descreve corretamente a foto.

Essa opcao evita alteracoes no PHP, mas caches de CDN ou navegador podem continuar mostrando a versao antiga temporariamente.

### Trocar o nome ou formato da imagem

Adicione o novo arquivo e altere `src` e, quando houver, `href`:

```html
<a href="assets/img/novo-servico.webp" target="_blank" rel="noopener noreferrer">
    <img
        src="assets/img/novo-servico.webp"
        alt="Descricao objetiva do que aparece na imagem"
        width="520"
        height="520"
        loading="lazy"
        decoding="async"
    >
</a>
```

Na galeria, `href` abre a imagem original e `src` exibe a miniatura. Atualize os dois.

### Boas praticas para imagens

- Use WebP ou JPEG otimizado para fotografias.
- Evite arquivos muito maiores do que o tamanho em que serao exibidos.
- Use nomes em minusculas, sem espacos e separados por hifen.
- Preserve `width` e `height` para reduzir mudancas de layout.
- Escreva `alt` descritivo; nao use apenas "imagem" ou o nome do arquivo.
- Use `loading="lazy"` em imagens abaixo da primeira dobra.
- A primeira imagem visivel pode usar `loading="eager"`.
- Comprima o video da hero e mantenha o poster para conexoes lentas.

## Como adicionar uma nova secao

### 1. Escolha a posicao no HTML

Abra `index.php` e insira a nova `<section>` entre as secoes existentes. Cada secao deve ter um `id` unico, usado nos links de navegacao.

Modelo basico:

```html
<section class="section section--soft" id="nova-secao">
    <div class="container">
        <div class="section__heading reveal">
            <span class="section__eyebrow">Categoria</span>
            <h2>Titulo claro da nova secao</h2>
            <p>Texto introdutorio opcional.</p>
        </div>

        <div class="nova-secao__grid reveal-group">
            <article class="nova-secao__card reveal">
                <h3>Titulo do item</h3>
                <p>Descricao do item.</p>
            </article>
        </div>
    </div>
</section>
```

Use `section--soft` quando quiser o fundo alternativo. Remova essa classe para usar o fundo padrao.

### 2. Adicione os estilos

Inclua os seletores em `assets/css/style.css`, preferencialmente perto das secoes relacionadas:

```css
.nova-secao__grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.25rem;
}

.nova-secao__card {
    padding: 1.5rem;
    border: 1px solid var(--line);
    border-radius: var(--radius);
    background: var(--surface);
    box-shadow: var(--shadow);
}

@media (max-width: 768px) {
    .nova-secao__grid {
        grid-template-columns: 1fr;
    }
}
```

Reutilize as variaveis CSS existentes em vez de repetir cores e medidas fixas.

### 3. Ative a animacao de entrada

- Adicione `reveal` em cada elemento que deve aparecer ao entrar na viewport.
- Adicione `reveal-group` no pai para aplicar atrasos progressivos aos filhos.
- O comportamento e controlado por `IntersectionObserver` em `assets/js/main.js`.
- Usuarios com `prefers-reduced-motion` recebem o conteudo sem animacao.

Exemplo:

```html
<div class="nova-secao__grid reveal-group">
    <article class="nova-secao__card reveal">...</article>
    <article class="nova-secao__card reveal">...</article>
</div>
```

### 4. Adicione a secao ao menu

Em `includes/header.php`, adicione o link nos menus desktop e mobile quando fizer sentido:

```html
<li><a href="/#nova-secao">Nova secao</a></li>
```

Use `/#nova-secao` no header compartilhado, pois o link tambem precisa funcionar quando o usuario estiver em `schedule.php`. Dentro da propria home, `#nova-secao` tambem funciona.

### 5. Atualize o rodape e o sitemap quando necessario

- Adicione um link no rodape da home em `index.php`.
- Se a mudanca criar uma nova pagina, adicione sua URL a `sitemap.xml`.
- Para uma nova pagina indexavel, defina titulo, descricao, canonical e imagem social antes de incluir `includes/head.php`.

## Como adicionar um novo servico

Os servicos sao cards do carrossel em `index.php`, dentro de `.service-carousel__ring`.

1. Adicione a foto em `assets/img/`, por exemplo `service-couro.jpg`.
2. Copie um `<article class="service-card service-card--carousel">` existente.
3. Defina um `id` unico e descritivo.
4. Atualize imagem, `alt`, titulo, descricao e link do WhatsApp.
5. Mantenha os atributos `data-service-card`, pois o JavaScript usa esse marcador.

```html
<article
    class="service-card service-card--carousel"
    data-service-card
    id="tratamento-couro"
>
    <img
        src="assets/img/service-couro.jpg"
        alt="Banco de couro recebendo tratamento de hidratacao"
        width="560"
        height="420"
        loading="lazy"
        decoding="async"
    >
    <div class="service-card__body">
        <h3>Tratamento de couro</h3>
        <p>Descricao objetiva do servico e do beneficio para o cliente.</p>
        <a
            href="https://wa.me/553135683754?text=Tenho%20interesse%20em%20tratamento%20de%20couro."
            target="_blank"
            rel="noopener noreferrer"
        >Solicitar avaliacao</a>
    </div>
</article>
```

O carrossel calcula a distribuicao com base na quantidade de elementos `data-service-card`, portanto normalmente nao e necessario alterar o JavaScript.

## Como adicionar itens a galeria

Na secao `#galeria` de `index.php`, copie um link existente e atualize numero, caminho e descricao:

```html
<a
    class="gallery-item reveal"
    href="assets/img/gallery-07.jpg"
    target="_blank"
    rel="noopener noreferrer"
>
    <img
        src="assets/img/gallery-07.jpg"
        alt="Descricao do resultado mostrado na fotografia"
        width="520"
        height="520"
        loading="lazy"
        decoding="async"
    >
</a>
```

Salve `gallery-07.jpg` em `assets/img/`. O grid se reorganiza de acordo com os estilos responsivos existentes.

## Como adicionar perguntas ao FAQ

Edite o array `$faqItems` no inicio de `index.php`:

```php
[
    'question' => 'A pergunta aparece aqui?',
    'answers' => [
        'Primeiro paragrafo da resposta.',
        'Segundo paragrafo opcional.',
    ],
],
```

O PHP gera automaticamente a numeracao, IDs, botoes e paineis. O acordeao e controlado por `[data-accordion]` em `assets/js/main.js`.

As respostas atuais sao impressas como HTML. Insira somente conteudo confiavel e mantenha tags simples, como `<strong>`, quando necessario.

## Como alterar cores e tipografia

Os principais tokens visuais ficam no inicio de `assets/css/style.css`:

```css
:root {
    --bg: #0b1117;
    --bg-soft: #121b24;
    --surface: #172330;
    --surface-2: #1e2e3d;
    --text: #eff4f8;
    --muted: #b2c0cc;
    --line: rgba(255, 255, 255, 0.12);
    --primary: #39cac5;
    --primary-strong: #2fb0ac;
    --primary-glow: rgba(57, 202, 197, 0.28);
    --shadow: 0 18px 48px rgba(0, 0, 0, 0.35);
    --radius: 16px;
    --font-main: 'Inter', system-ui, -apple-system, sans-serif;
}
```

Para trocar a cor da marca, altere principalmente `--primary`, `--primary-strong` e `--primary-glow`. Verifique contraste de texto, botoes, foco e estados de hover depois da mudanca.

As fontes externas sao carregadas em `includes/head.php` e tambem existe um `@import` no topo do CSS. Ao remover ou trocar uma fonte, revise os dois locais para evitar requisicoes desnecessarias.

## JavaScript e comportamentos

O arquivo `assets/js/main.js` controla:

- fallback automatico para imagens quebradas;
- ocultacao de video que falhou ao carregar;
- estado visual e ocultacao temporaria do header durante o scroll;
- parallax do video da hero;
- abertura e fechamento do menu mobile;
- botao de voltar ao topo;
- animacoes `.reveal` com `IntersectionObserver`;
- carrossel 3D de servicos, setas, teclado e arraste;
- acordeao do FAQ.

Ao criar um comportamento novo:

1. Use atributos `data-*` para selecionar componentes, evitando acoplar logica a classes puramente visuais.
2. Verifique se o elemento existe antes de registrar eventos.
3. Preserve navegacao por teclado e atributos ARIA.
4. Evite bloquear scroll com listeners pesados.
5. Teste com `prefers-reduced-motion: reduce` quando houver movimento.

## Agendamento

### Fluxo atual

1. `schedule.php` faz uma requisicao GET para `api/appointments.php`.
2. A API le `data/appointments.json`.
3. O calendario conta os horarios ocupados de cada dia.
4. Ao selecionar um horario livre, o usuario e encaminhado ao WhatsApp.

### Formato dos dados

`data/appointments.json` deve conter um array JSON de datas e horarios no formato ISO local:

```json
[
    "2026-06-10T08:00:00",
    "2026-06-10T09:00:00",
    "2026-06-11T14:00:00"
]
```

O calendario atual gera horarios inteiros das `08:00` as `18:00`. O endpoint aceita somente GET; nao existe cadastro administrativo nem POST publico.

Para marcar um horario manualmente:

1. Abra `data/appointments.json`.
2. Adicione a data no formato correto.
3. Mantenha o JSON valido, com aspas duplas e virgulas entre os itens.
4. Teste a pagina de agenda.

Em producao, garanta permissao de leitura para o processo do servidor web. Como o endpoint pode criar o arquivo quando ele nao existe, a pasta `data/` tambem precisa de escrita nesse primeiro acesso.

## SEO, redes sociais e favicon

### Metadados por pagina

Antes de incluir `includes/head.php`, defina:

```php
<?php
$pageTitle = 'Titulo da pagina | TeleClean Detail';
$pageDescription = 'Descricao objetiva entre aproximadamente 140 e 160 caracteres.';
$canonicalUrl = 'https://www.teleclean.com.br/nova-pagina.php';
$ogImage = 'https://www.teleclean.com.br/assets/img/og-nova-pagina.jpg';
include __DIR__ . '/includes/head.php';
?>
```

Prefira URL absoluta para `og:image`, pois redes sociais podem nao resolver caminhos relativos de forma consistente.

### Dados estruturados

O JSON-LD de `includes/head.php` informa nome, telefone, endereco, horario, Instagram e catalogo de servicos. Atualize esse bloco sempre que os dados comerciais mudarem.

### Favicon

O favicon atual e `assets/img/favicon.svg`. Para boa leitura em abas pequenas:

- use um simbolo simples;
- evite o nome completo da empresa;
- prefira poucos detalhes e alto contraste;
- teste em 16 x 16 e 32 x 32 px.

### Sitemap e robots

- Atualize `sitemap.xml` quando adicionar ou remover paginas publicas.
- Revise `robots.txt` antes de publicar em outro dominio ou ambiente.

## Acessibilidade e desempenho

- Mantenha apenas um `<h1>` principal por pagina.
- Preserve a ordem hierarquica de titulos: `h1`, `h2`, `h3`.
- Todo controle clicavel deve ser um link ou botao real.
- Imagens informativas precisam de `alt`; imagens decorativas podem usar `alt=""`.
- Mantenha `aria-expanded`, `aria-controls` e `hidden` em menus e acordeoes.
- Nao remova a `skip-link` da pagina principal.
- Verifique contraste ao alterar cores.
- Comprima fotos e video antes de publicar.
- Evite carregar imagens abaixo da dobra com `loading="eager"`.
- Teste o site em desktop, tablet e celular.
- Confirme que o conteudo continua acessivel sem animacao.

## Checklist antes de publicar

- [ ] Executar verificacao de sintaxe PHP.
- [ ] Validar JavaScript.
- [ ] Conferir a home e a agenda em diferentes larguras.
- [ ] Testar menu desktop e mobile.
- [ ] Testar todos os links e mensagens do WhatsApp.
- [ ] Conferir telefone, e-mail, endereco, horario e Instagram.
- [ ] Verificar se todas as imagens carregam e possuem `alt` adequado.
- [ ] Testar video e poster da hero.
- [ ] Testar carrossel com mouse, toque, teclado e setas.
- [ ] Testar abertura e fechamento do FAQ.
- [ ] Validar `data/appointments.json` e a API.
- [ ] Conferir titulo, description, canonical e imagem social.
- [ ] Atualizar `sitemap.xml` quando houver novas paginas.
- [ ] Confirmar que nenhum arquivo temporario ou dado sensivel entrou no commit.

Comandos basicos de verificacao:

```bash
php -l index.php
php -l schedule.php
php -l includes/head.php
php -l includes/header.php
php -l includes/footer.php
php -l api/appointments.php
node --check assets/js/main.js
```

## Licenca

Consulte o arquivo `LICENSE` na raiz do projeto.
