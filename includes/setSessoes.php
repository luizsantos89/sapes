<?php
    require '../Model/FuncionarioDAO.php';
    require '../Model/SecaoDAO.php';
    require '../Model/DivisaoDAO.php';
    require '../Model/GerenciaDAO.php';
    require '../Model/TipoSancaoDAO.php';
    require '../Model/SancaoDAO.php';
    require '../Model/DesempenhoDAO.php';
    require '../Model/AbsenteismoDAO.php';    
    
    $secaoDAO = new SecaoDAO();
    $_SESSION['secoes'] = $secaoDAO->getSecoes();
    $divisaoDAO = new DivisaoDAO();
    $_SESSION['divisoes'] = $divisaoDAO->getDivisoes();
    $gerenciaDAO = new GerenciaDAO();
    $_SESSION['gerencias'] = $gerenciaDAO->getGerencias();
    $tipoSancaoDAO = new TipoSancaoDAO();
    $_SESSION['tipoSancoes'] = $tipoSancaoDAO->getTipoSancoes();
    $sancaoDAO = new SancaoDAO();
    $_SESSION['sancoes'] = $sancaoDAO->getSancoes();
    $desempenhoDAO = new DesempenhoDAO();
    $_SESSION['notasDesempenho'] = $desempenhoDAO->getDesempenhos();
    $absenteismoDAO = new AbsenteismoDAO();
    $_SESSION['absenteismo'] = $absenteismoDAO->getAbsenteismo();