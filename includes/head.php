<?php
$pageTitle = $pageTitle ?? 'TeleClean';
$pageDescription = $pageDescription ?? 'Estética automotiva premium em Belo Horizonte.';
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
      "telephone": "+55 31 99999-9999",
      "priceRange": "$$$",
      "description": "Empresa de estética automotiva premium em Belo Horizonte com foco em lavagem técnica, higienização, polimento e proteção veicular.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Av. Raja Gabáglia, 2450",
        "addressLocality": "Belo Horizonte",
        "addressRegion": "MG",
        "postalCode": "30494-170",
        "addressCountry": "BR"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -19.9526,
        "longitude": -43.9654
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
          "opens": "08:00",
          "closes": "18:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Saturday",
          "opens": "08:00",
          "closes": "13:00"
        }
      ],
      "sameAs": [
        "https://www.instagram.com/teleclean",
        "https://www.facebook.com/teleclean"
      ],
      "areaServed": "Belo Horizonte e região",
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Serviços de estética automotiva",
        "itemListElement": [
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Lavagem técnica"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Higienização interna"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Polimento técnico"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Cristalização"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Vitrificação"}},
          {"@type":"Offer","itemOffered":{"@type":"Service","name":"Detalhamento completo"}}
        ]
      }
    }
    
    </script>
    <script src="assets/js/main.js" defer></script>
</head>