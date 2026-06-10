<?php
$pageTitle = 'TeleClean Detail | Estética Automotiva em Belo Horizonte';
$pageDescription = 'TeleClean Detail | Estética Automotiva. Especialistas em polimento técnico, vitrificação e detalhamento automotivo em Belo Horizonte. Fale no WhatsApp e solicite seu orçamento.';
$canonicalUrl = 'https://www.teleclean.com.br/';
$ogImage = 'assets/img/og-cover.jpg';
include __DIR__ . '/includes/head.php';
?>
<body>
<a class="skip-link" href="#conteudo">Pular para conteúdo</a>
<?php include __DIR__ . '/includes/header.php'; ?>

<main id="conteudo">
    <?php
    $faqItems = [
        [
            'question' => 'Quanto tempo leva um serviço de estética automotiva?',
            'answers' => [
                'O tempo varia conforme o pacote e o estado do veículo. Após a análise inicial, o cliente recebe uma estimativa clara de prazo.',
            ],
        ],
        [
            'question' => 'Precisa agendar antes?',
            'answers' => [
                'Sim. O atendimento com hora marcada ajuda a manter organização, atenção ao veículo e melhor qualidade de execução.',
            ],
        ],
        [
            'question' => 'Qual a diferença entre cristalização e vitrificação?',
            'answers' => [
                'Ambos são serviços de proteção com propostas diferentes. A recomendação ideal depende do objetivo do cliente, rotina de uso e condição da pintura.',
            ],
        ],
        [
            'question' => 'A higienização ajuda em odores e sujeira impregnada?',
            'answers' => [
                'Sim. Em muitos casos, a higienização interna combinada com tratamento específico melhora bastante a sensação de limpeza e conforto.',
            ],
        ],
        [
            'question' => 'Vocês atendem qualquer tipo de veículo?',
            'answers' => [
                'O ideal é enviar modelo, fotos e objetivo do serviço pelo WhatsApp para confirmar o melhor atendimento e o pacote mais adequado.',
            ],
        ],
        [
            'question' => 'Quais são os contatos da empresa?',
            'answers' => [
                '<strong>Telefone e WhatsApp:</strong> (31) 3568-3754',
                '<strong>E-mail:</strong> contato@teleclean.com.br',
                '<strong>PIX da empresa:</strong> contato@teleclean.com.br',
            ],
        ],
    ];
    ?>
    <section class="hero" id="inicio" aria-label="Apresentação principal">
        <video class="hero__video" autoplay muted loop playsinline preload="metadata" poster="assets/img/hero-poster.jpg" aria-hidden="true">
            <source src="assets/video/hero-detail.mp4" type="video/mp4">
        </video>
        <div class="hero__overlay" aria-hidden="true"></div>
        <div class="container hero__content">
            <div class="eyebrow reveal">TeleClean Detail | Estética Automotiva</div>
            <!-- <h1 class="reveal">Polimento técnico, vitrificação e detalhamento para deixar seu carro com acabamento de alto nível.</h1> -->
            <h1 class="reveal">Estética automotiva premium</h1>
            <!-- <h1 class="reveal">Estética automotiva premium para quem valoriza cada detalhe do veículo.</h1> -->
            <p class="hero__text reveal">Atendemos em Belo Horizonte com processo técnico, transparência no diagnóstico e foco total em resultado visual. Seu veículo sai com mais brilho, proteção e valor percebido.</p>
            <!-- <div class="eyebrow reveal">Cuidado técnico • acabamento premium • atendimento local</div> -->
            <!-- <p class="hero__text reveal">Lavagem técnica, higienização, polimento e proteção com padrão profissional, processo cuidadoso e atendimento com hora marcada em Belo Horizonte.</p> -->
            <div class="hero__actions reveal">
                <a class="btn btn--primary" href="#orcamento">Solicitar orçamento</a>
                <a class="btn btn--ghost" href="https://wa.me/553135683754?text=Ol%C3%A1%2C%20quero%20um%20or%C3%A7amento%20para%20est%C3%A9tica%20automotiva." target="_blank" rel="noopener noreferrer">Falar no WhatsApp</a>
            </div>
            <!-- <ul class="hero__metrics" role="list">
                <li class="metric reveal"><strong>Hora marcada</strong><span>Atendimento organizado, sem pressa e com previsibilidade.</span></li>
                <li class="metric reveal"><strong>Produtos profissionais</strong><span>Linhas selecionadas para limpeza, brilho e proteção.</span></li>
                <li class="metric reveal"><strong>Acabamento premium</strong><span>Foco em detalhe visual, toque final e apresentação.</span></li>
            </ul> -->
        </div>
    </section>

    <section class="section section--compact" id="servicos">
        <div class="container">
            <div class="section__heading reveal">
                <span class="section__eyebrow">Serviços</span>
                <h2>Tratamentos pensados para estética, conservação e valorização do veículo.</h2>
                <p>Cada serviço foi descrito para facilitar a decisão do cliente e levá-lo direto ao contato comercial.</p>
                <p class="services-summary">Na TeleClean, nossos serviços vão além da lavagem: oferecemos soluções completas de proteção e revitalização, seja para o dia a dia (Beginner) ou para um upgrade (Profissional). Destaques: Polimento técnico, Vitrificação, Guarnaminha e Clarixa. Também realizamos limpeza de motor e caixa de roda, tratamento de couro e higienização interna.</p>
            </div>

            <div class="service-carousel service-carousel--mini" data-service-carousel aria-label="Carrossel 3D de serviços">
                <div class="service-carousel__stage" data-service-stage tabindex="0">
                    <button class="carousel-arrow carousel-arrow--prev" type="button" data-carousel-prev aria-label="Serviço anterior">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <button class="carousel-arrow carousel-arrow--next" type="button" data-carousel-next aria-label="Próximo serviço">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                    <div class="service-carousel__ring" data-service-ring>
                        <article class="service-card service-card--carousel" data-service-card id="lavagem-tecnica">
                            <img src="assets/img/service-lavagem.jpg" alt="Veículo preto recebendo lavagem técnica detalhada" width="560" height="420" loading="eager" decoding="async">
                            <div class="service-card__body">
                                <h3>Lavagem técnica</h3>
                                <p>Limpeza externa com processo mais cuidadoso, reduzindo riscos e preservando melhor pintura, rodas e acabamentos.</p>
                                <a href="https://wa.me/553135683754?text=Tenho%20interesse%20em%20lavagem%20t%C3%A9cnica." target="_blank" rel="noopener noreferrer">Solicitar avaliação</a>
                            </div>
                        </article>
                        <article class="service-card service-card--carousel" data-service-card id="higienizacao-interna">
                            <img src="assets/img/service-higienizacao.jpg" alt="Interior automotivo claro passando por higienização interna" width="560" height="420" loading="lazy" decoding="async">
                            <div class="service-card__body">
                                <h3>Higienização interna</h3>
                                <p>Tratamento interno para bancos, carpetes, painel e superfícies, com foco em limpeza profunda, conforto e sensação de cuidado.</p>
                                <a href="https://wa.me/553135683754?text=Quero%20um%20or%C3%A7amento%20de%20higieniza%C3%A7%C3%A3o%20interna." target="_blank" rel="noopener noreferrer">Pedir orçamento</a>
                            </div>
                        </article>
                        <article class="service-card service-card--carousel" data-service-card id="polimento-tecnico">
                            <img src="assets/img/service-polimento.jpg" alt="Capô automotivo polido com reflexo nítido em ambiente escuro" width="560" height="420" loading="lazy" decoding="async">
                            <div class="service-card__body">
                                <h3>Polimento técnico</h3>
                                <p>Correção visual e ganho de profundidade no brilho com avaliação prévia do verniz e abordagem adequada para cada caso.</p>
                                <a href="https://wa.me/553135683754?text=Gostaria%20de%20avaliar%20polimento%20t%C3%A9cnico." target="_blank" rel="noopener noreferrer">Agendar análise</a>
                            </div>
                        </article>
                        <article class="service-card service-card--carousel" data-service-card id="cristalizacao">
                            <img src="assets/img/service-cristalizacao.jpg" alt="Carro escuro com acabamento brilhante após cristalização" width="560" height="420" loading="lazy" decoding="async">
                            <div class="service-card__body">
                                <h3>Cristalização</h3>
                                <p>Proteção com efeito visual refinado para quem busca brilho consistente e manutenção estética mais prática no dia a dia.</p>
                                <a href="https://wa.me/553135683754?text=Quero%20saber%20sobre%20cristaliza%C3%A7%C3%A3o." target="_blank" rel="noopener noreferrer">Ver disponibilidade</a>
                            </div>
                        </article>
                        <article class="service-card service-card--carousel" data-service-card id="vitrificacao">
                            <img src="assets/img/service-vitrificacao.jpg" alt="Aplicação de proteção vitrificadora em pintura automotiva" width="560" height="420" loading="lazy" decoding="async">
                            <div class="service-card__body">
                                <h3>Vitrificação</h3>
                                <p>Camada de proteção avançada para quem deseja maior preservação estética, brilho controlado e rotina de limpeza facilitada.</p>
                                <a href="https://wa.me/553135683754?text=Tenho%20interesse%20em%20vitrifica%C3%A7%C3%A3o." target="_blank" rel="noopener noreferrer">Solicitar orçamento</a>
                            </div>
                        </article>
                        <article class="service-card service-card--carousel" data-service-card id="limpeza-bancos-teto">
                            <img src="assets/img/service-bancos.jpg" alt="Banco automotivo sendo higienizado com equipamento profissional" width="560" height="420" loading="lazy" decoding="async">
                            <div class="service-card__body">
                                <h3>Limpeza de bancos e teto</h3>
                                <p>Serviço indicado para remoção de sujeiras acumuladas, manchas leves e renovação visual do interior.</p>
                                <a href="https://wa.me/553135683754?text=Preciso%20de%20limpeza%20de%20bancos%20e%20teto." target="_blank" rel="noopener noreferrer">Falar com a equipe</a>
                            </div>
                        </article>
                        <article class="service-card service-card--carousel" data-service-card id="revitalizacao-plasticos">
                            <img src="assets/img/service-plasticos.jpg" alt="Detalhe de plástico automotivo revitalizado no painel e acabamento interno" width="560" height="420" loading="lazy" decoding="async">
                            <div class="service-card__body">
                                <h3>Revitalização de plásticos</h3>
                                <p>Recuperação estética de áreas internas e externas com aspecto mais uniforme e acabamento mais elegante.</p>
                                <a href="https://wa.me/553135683754?text=Quero%20revitalizar%20pl%C3%A1sticos%20do%20ve%C3%ADculo." target="_blank" rel="noopener noreferrer">Solicitar avaliação</a>
                            </div>
                        </article>
                        <article class="service-card service-card--carousel" data-service-card id="remocao-odores">
                            <img src="assets/img/service-odores.jpg" alt="Interior limpo de veículo após processo de remoção de odores" width="560" height="420" loading="lazy" decoding="async">
                            <div class="service-card__body">
                                <h3>Remoção de odores</h3>
                                <p>Tratamento voltado para neutralização de odores indesejados, tornando a cabine mais agradável para uso diário.</p>
                                <a href="https://wa.me/553135683754?text=Gostaria%20de%20remover%20odores%20do%20ve%C3%ADculo." target="_blank" rel="noopener noreferrer">Agendar atendimento</a>
                            </div>
                        </article>
                        <article class="service-card service-card--carousel" data-service-card id="detalhamento-completo">
                            <img src="assets/img/service-detalhamento.jpg" alt="Veículo preto em estúdio após detalhamento completo premium" width="560" height="420" loading="lazy" decoding="async">
                            <div class="service-card__body">
                                <h3>Detalhamento completo</h3>
                                <p>Combinação de etapas para quem deseja renovar apresentação, elevar percepção de cuidado e entregar o carro em outro nível.</p>
                                <a href="https://wa.me/553135683754?text=Quero%20um%20detalhamento%20completo." target="_blank" rel="noopener noreferrer">Montar pacote</a>
                            </div>
                        </article>
                    </div>
                </div>
                <p class="service-carousel__hint">Arraste para girar o carrossel e passe o mouse para destacar cada serviço.</p>
            </div>
        </div>
    </section>

    <section class="section section--soft" id="diferenciais">
        <div class="container">
            <div class="section__heading reveal">
                <span class="section__eyebrow">Por que escolher</span>
                <h2>Um padrão de atendimento pensado para confiança, técnica e resultado visual consistente.</h2>
            </div>
            <div class="benefits-grid reveal-group">
                <article class="benefit-card reveal">
                    <div class="icon-wrapper">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <h3>Equipe especializada</h3>
                    <p>Processos orientados por avaliação real do estado do veículo e pela escolha correta de cada serviço.</p>
                </article>
                <article class="benefit-card reveal">
                    <div class="icon-wrapper">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="22" y1="12" x2="18" y2="12"></line><line x1="6" y1="12" x2="2" y2="12"></line><line x1="12" y1="6" x2="12" y2="2"></line><line x1="12" y1="22" x2="12" y2="18"></line></svg>
                    </div>
                    <h3>Atenção aos detalhes</h3>
                    <p>Acabamentos, frestas, áreas internas e superfícies recebem cuidado criterioso do início à entrega.</p>
                </article>
                <article class="benefit-card reveal">
                    <div class="icon-wrapper">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <h3>Produtos de qualidade</h3>
                    <p>Uso de linhas profissionais para limpeza, proteção e conservação, sempre com aplicação adequada.</p>
                </article>
                <article class="benefit-card reveal">
                    <div class="icon-wrapper">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <h3>Técnicas seguras</h3>
                    <p>Métodos pensados para preservar materiais, pintura, tecidos, couro, plásticos e componentes sensíveis.</p>
                </article>
                <article class="benefit-card reveal">
                    <div class="icon-wrapper">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <h3>Resultado superior</h3>
                    <p>Brilho controlado, aspecto limpo, sensação de renovação e apresentação mais valorizada.</p>
                </article>
                <article class="benefit-card reveal">
                    <div class="icon-wrapper">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <h3>Atendimento Premium</h3>
                    <p>Contato rápido, orientação objetiva, organização no agendamento e clareza total para o cliente.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section" id="antes-depois">
        <div class="container">
            <div class="section__heading reveal">
                <span class="section__eyebrow">Antes e depois</span>
                <h2>Comparativos que mostram limpeza, recuperação visual e ganho de acabamento.</h2>
                <p>Os exemplos abaixo ajudam o cliente a entender o tipo de transformação possível em pintura, interior e detalhes.</p>
            </div>
            <div class="compare-grid reveal-group">
                <article class="compare-card reveal">
                    <div class="compare-card__media">
                        <figure>
                            <img src="assets/img/before-externo.jpg" alt="Carro escuro com pintura opaca antes do tratamento estético" width="580" height="420" loading="lazy" decoding="async">
                            <figcaption>Antes</figcaption>
                        </figure>
                        <figure>
                            <img src="assets/img/after-externo.jpg" alt="Carro escuro com brilho refinado após tratamento estético premium" width="580" height="420" loading="lazy" decoding="async">
                            <figcaption>Depois</figcaption>
                        </figure>
                    </div>
                    <h3>Recuperação de brilho externo</h3>
                    <p>Mais profundidade de cor, melhor apresentação e aparência de cuidado em cada reflexo.</p>
                </article>
                <article class="compare-card reveal">
                    <div class="compare-card__media">
                        <figure>
                            <img src="assets/img/before-interno.jpg" alt="Interior automotivo com marcas de uso antes da higienização" width="580" height="420" loading="lazy" decoding="async">
                            <figcaption>Antes</figcaption>
                        </figure>
                        <figure>
                            <img src="assets/img/after-interno.jpg" alt="Interior automotivo limpo e renovado após higienização técnica" width="580" height="420" loading="lazy" decoding="async">
                            <figcaption>Depois</figcaption>
                        </figure>
                    </div>
                    <h3>Renovação do interior</h3>
                    <p>Ambiente mais agradável, sensação de limpeza real e acabamento visual muito mais uniforme.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section section--soft" id="processo">
        <div class="container">
            <div class="section__heading reveal">
                <span class="section__eyebrow">Processo</span>
                <h2>Um fluxo simples para orientar o cliente com clareza desde o primeiro contato.</h2>
            </div>
            <div class="process-grid reveal-group">
                <article class="process-step reveal"><span>01</span><h3>Análise do veículo</h3><p>A equipe entende o estado geral, o nível de uso e as prioridades do cliente.</p></article>
                <article class="process-step reveal"><span>02</span><h3>Indicação do serviço</h3><p>É sugerido o pacote mais coerente para estética, higienização ou proteção.</p></article>
                <article class="process-step reveal"><span>03</span><h3>Execução técnica</h3><p>O trabalho é realizado com método, organização e foco em acabamento superior.</p></article>
                <article class="process-step reveal"><span>04</span><h3>Entrega final</h3><p>O veículo é apresentado com orientação de manutenção e próximos cuidados recomendados.</p></article>
            </div>
        </div>
    </section>

    <section class="section" id="depoimentos" aria-labelledby="titulo-depoimentos">
        <div class="container">
            <div class="section__heading reveal">
                <span class="section__eyebrow">Depoimentos</span>
                <h2 id="titulo-depoimentos">Clientes que procuram acabamento, confiança e atendimento profissional.</h2>
            </div>
            <div class="testimonials-grid reveal-group" itemscope itemtype="https://schema.org/ItemList">
                <article class="testimonial-card reveal" itemprop="itemListElement" itemscope itemtype="https://schema.org/Review">
                    <meta itemprop="position" content="1">
                    <p itemprop="reviewBody">“O carro voltou com outra apresentação. O atendimento foi objetivo, explicaram o processo e o acabamento ficou acima do que eu esperava.”</p>
                    <footer><strong itemprop="author">Marcos P.</strong><span> Polimento técnico e proteção</span></footer>
                </article>
                <article class="testimonial-card reveal" itemprop="itemListElement" itemscope itemtype="https://schema.org/Review">
                    <meta itemprop="position" content="2">
                    <p itemprop="reviewBody">“Gostei da organização no horário e do cuidado interno. A higienização deixou o ambiente muito mais agradável e com aparência realmente premium.”</p>
                    <footer><strong itemprop="author">Renata S.</strong><span> Higienização interna</span></footer>
                </article>
                <article class="testimonial-card reveal" itemprop="itemListElement" itemscope itemtype="https://schema.org/Review">
                    <meta itemprop="position" content="3">
                    <p itemprop="reviewBody">“Dá para perceber atenção aos detalhes. Não é uma lavagem comum. O carro ficou limpo, alinhado e com brilho muito mais elegante.”</p>
                    <footer><strong itemprop="author">Felipe A.</strong><span> Lavagem técnica</span></footer>
                </article>
            </div>
        </div>
    </section>

    <section class="section section--compact" id="galeria">
        <div class="container">
            <div class="section__heading reveal">
                <span class="section__eyebrow">Galeria</span>
                <h2>Alguns ângulos do padrão visual que o cliente encontra no final do serviço.</h2>
            </div>
            <div class="gallery-grid reveal-group">
                <a class="gallery-item reveal" href="assets/img/gallery-01.jpg" target="_blank" rel="noopener noreferrer"><img src="assets/img/gallery-01.jpg" alt="SUV preto com pintura brilhante em área interna da estética automotiva" width="520" height="520" loading="lazy" decoding="async"></a>
                <a class="gallery-item reveal" href="assets/img/gallery-02.jpg" target="_blank" rel="noopener noreferrer"><img src="assets/img/gallery-02.jpg" alt="Sedã prata com rodas limpas e acabamento externo refinado" width="520" height="520" loading="lazy" decoding="async"></a>
                <a class="gallery-item reveal" href="assets/img/gallery-03.jpg" target="_blank" rel="noopener noreferrer"><img src="assets/img/gallery-03.jpg" alt="Interior automotivo escuro com painel limpo e aspecto renovado" width="520" height="520" loading="lazy" decoding="async"></a>
                <a class="gallery-item reveal" href="assets/img/gallery-04.jpg" target="_blank" rel="noopener noreferrer"><img src="assets/img/gallery-04.jpg" alt="Detalhe de farol e capô com reflexo após detalhamento automotivo" width="520" height="520" loading="lazy" decoding="async"></a>
                <a class="gallery-item reveal" href="assets/img/gallery-05.jpg" target="_blank" rel="noopener noreferrer"><img src="assets/img/gallery-05.jpg" alt="Bancos claros limpos após higienização automotiva premium" width="520" height="520" loading="lazy" decoding="async"></a>
                <a class="gallery-item reveal" href="assets/img/gallery-06.jpg" target="_blank" rel="noopener noreferrer"><img src="assets/img/gallery-06.jpg" alt="Carro preto em ambiente escuro mostrando profundidade de brilho" width="520" height="520" loading="lazy" decoding="async"></a>
            </div>
        </div>
    </section>

    <section class="section section--soft" id="faq">
        <div class="container container--narrow">
            <div class="section__heading reveal">
                <span class="section__eyebrow">FAQ</span>
                <h2>Perguntas frequentes antes de solicitar orçamento ou agendar.</h2>
            </div>
            <div class="faq-list" data-accordion>
                <?php foreach ($faqItems as $index => $faqItem): ?>
                <article class="faq-item reveal">
                    <h3>
                        <button type="button" aria-expanded="false" aria-controls="faq-<?php echo $index + 1; ?>" id="faq-button-<?php echo $index + 1; ?>"><?php echo sprintf('%02d.', $index + 1); ?> <?php echo $faqItem['question']; ?></button>
                    </h3>
                    <div id="faq-<?php echo $index + 1; ?>" role="region" aria-labelledby="faq-button-<?php echo $index + 1; ?>" hidden>
                        <?php foreach ($faqItem['answers'] as $answer): ?>
                        <p><?php echo $answer; ?></p>
                        <?php endforeach; ?>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section cta-section" id="orcamento">
        <div class="container cta-section__inner reveal">
            <div>
                <span class="section__eyebrow">Orçamento e agendamento</span>
                <h2>Seu veículo pode ter brilho de vitrine, proteção duradoura e acabamento que chama atenção.</h2>
                <p>Envie fotos no WhatsApp e receba uma avaliacao tecnica da TeleClean com orientacao clara do melhor pacote para o seu objetivo.</p>
            </div>
            <div class="cta-section__actions">
                <a class="btn btn--primary" href="https://wa.me/553135683754?text=Ol%C3%A1%2C%20quero%20fazer%20um%20or%C3%A7amento%20para%20meu%20ve%C3%ADculo." target="_blank" rel="noopener noreferrer">Chamar no WhatsApp</a>
                <a class="btn btn--secondary" href="/schedule.php">Ver agenda</a>
            </div>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="site-footer__grid">
            <div class="footer-brand">
                <div class="brand__wordmark" style="font-size: 1.4rem; margin-bottom: 1.5rem;">TELE CLEAN</div>
                <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.6;">Especialistas em preservação e estética automotiva de alto padrão. Unindo técnica avançada e produtos de elite para resultados extraordinários.</p>
            </div>
            <div>
                <h4>Serviços</h4>
                <ul>
                    <li><a href="#servicos">Polimento Técnico</a></li>
                    <li><a href="#servicos">Vitrificação</a></li>
                    <li><a href="#servicos">Higienização Interna</a></li>
                    <li><a href="#servicos">Lavagem Detalhada</a></li>
                </ul>
            </div>
            <div>
                <h4>Navegação</h4>
                <ul>
                    <li><a href="#inicio">Início</a></li>
                    <li><a href="#diferenciais">Diferenciais</a></li>
                    <li><a href="#antes-depois">Antes e Depois</a></li>
                    <li><a href="#faq">Dúvidas</a></li>
                </ul>
            </div>
            <div>
                <h4>Contato e Localização</h4>
                <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Rua Benjamim Flores, 170<br>Santo Antônio, Belo Horizonte</p>
                <iframe 
                    class="footer-map"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3750.366430342617!2d-43.9463286!3d-19.95109!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa69837f8f6e80b%3A0x7d6c6e76d97a9f6d!2sR.%20Benjamim%20Flores%2C%20170%20-%20Santo%20Ant%C3%B4nio%2C%20Belo%20Horizonte%20-%20MG%2C%2030350-130!5e0!3m2!1spt-BR!2sbr!4v1710000000000!5m2!1spt-BR!2sbr" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <p style="color: var(--primary); font-weight: 700; font-size: 1rem;">(31) 3568-3754</p>
            </div>
        </div>
        <div class="site-footer__bottom">
            <p style="font-size: 0.75rem; color: var(--muted);">&copy; <?php echo date('Y'); ?> TeleClean Detail. Todos os direitos reservados.</p>
            <button class="back-to-top" data-back-to-top>Voltar ao topo</button>
        </div>
    </div>
</footer>
</body>
</html>