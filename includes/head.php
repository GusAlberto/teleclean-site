<?php
$pageTitle = $pageTitle ?? 'TeleClean';
$pageDescription = $pageDescription ?? 'TeleClean | Estética Automotiva em Belo Horizonte. Especialistas em polimento técnico, vitrificação e detalhamento automotivo.';
$canonicalUrl = $canonicalUrl ?? 'https://www.teleclean.com.br/';
$ogImage = $ogImage ?? 'assets/img/og-cover.jpg';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="keywords" content="estética automotiva premium, higienização automotiva, polimento técnico, vitrificação, lavagem técnica, Belo Horizonte">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:site_name" content="TeleClean">
    <meta property="og:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image:alt" content="Veículo premium com acabamento refinado após estética automotiva">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="theme-color" content="#0f1316">
    <link rel="icon" type="image/svg+xml" href="assets/img/favicon.svg">
    <link rel="preconnect" href="https://api.fontshare.com" crossorigin>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@400,500,700,900&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AutoDetailing",
      "name": "TeleClean",
      "image": "https://www.teleclean.com.br/assets/img/og-cover.jpg",
      "url": "https://www.teleclean.com.br/",
      "telephone": "+55 31 3568-3754",
      "priceRange": "$$$",
      "description": "TeleClean | Estética Automotiva. Especialistas em polimento técnico, vitrificação e detalhamento automotivo em Belo Horizonte.",
      "email": "contato@teleclean.com.br",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Rua Benjamim Flores, 170 - Santo Antônio",
        "addressLocality": "Belo Horizonte",
        "addressRegion": "MG",
        "addressCountry": "BR"
      },
      "openingHours": "Mo-Sa 08:00-18:00",
      "sameAs": [
        "https://www.instagram.com/teleclean_/"
      ],
      "areaServed": "Belo Horizonte e região metropolitana",
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Serviços de estética automotiva",
        "itemListElement": [
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Polimento técnico"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Vitrificação"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Detalhamento automotivo"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Higienização interna"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Lavagem técnica"}}
        ]
      }
    }
    
    </script>
    <script src="assets/js/main.js" defer></script>
</head>