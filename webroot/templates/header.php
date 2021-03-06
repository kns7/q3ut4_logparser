<?php
if(!is_null($app)){
    $uri = explode('/',$app->request->getResourceUri());
}else{
    $uri = [];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>12 Salopards - Urban Terror Statistiques</title>
    <style type="text/css">*{ margin: 0; padding: 0;}</style>
    <link rel="icon" href="/favicon_16.png" sizes="16x16">
    <link rel="icon" href="/favicon_32.png" sizes="32x32">
    <link rel="icon" href="/favicon_48.png" sizes="48x48">
    <link rel="icon" href="/favicon_64.png" sizes="64x64">
    <link rel="icon" href="/favicon_72.png" sizes="72x72">
    <link rel="icon" href="/favicon_150.png" sizes="150x150">
    <link rel="icon" href="/favicon_160.png" sizes="160x160">
    <link rel="icon" href="/favicon_180.png" sizes="180x180">
    <link rel="icon" href="/favicon_192.png" sizes="192x192">
    <link rel="apple-touch-icon" href="/favicon_180.png" />
    <link rel="stylesheet" type="text/css" href="/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<nav class="navbar sticky-top navbar-dark navbar-expand-lg bg-dark">
    <a class="navbar-brand text-primary" href="/">URT Stats</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?= ($uri[1] == "")?"active":"";?>" href="/"><i class="fas fa-trophy"></i> Classement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($uri[1] == "player")?"active":"";?>" href="/player"><i class="fas fa-user"></i> Joueurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($uri[1] == "vs")?"active":"";?>" href="/vs"><i class="fas fa-exchange-alt"></i> Versus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($uri[1] == "games")?"active":"";?>" href="/games"><i class="fas fa-gamepad"></i> Parties</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="https://urt-admin.12salopards.fr"><i class="fas fa-sliders-h"></i> Server Manager</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid">