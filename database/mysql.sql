-- ========================================
-- Banco de Dados: Sistema de Clínica
-- Projeto: TotemAtendimento
-- ========================================

CREATE DATABASE IF NOT EXISTS clinica;
USE clinica;

-- ========================================
-- Tabela: pacientes
-- ========================================
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    data_nascimento DATE,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    rg VARCHAR(20),
    telefone VARCHAR(15),
    email VARCHAR(100),
    genero VARCHAR(20),
    estado_civil VARCHAR(20),
    senha INT NOT NULL,
    status VARCHAR(20) DEFAULT 'aguardando',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================================
-- Tabela: enderecos
-- ========================================
CREATE TABLE enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    cep VARCHAR(10),
    logradouro VARCHAR(100),
    numero VARCHAR(10),
    bairro VARCHAR(50),
    cidade VARCHAR(50),

    FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
);

-- ========================================
-- Tabela: informacoes_medicas
-- ========================================
CREATE TABLE informacoes_medicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    tipo_sanguineo VARCHAR(5),
    plano_saude VARCHAR(100),
    alergias TEXT,
    doencas_pre_existentes TEXT,
    medicamentos TEXT,

    FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
);

-- ========================================
-- Tabela: medicos
-- ========================================
CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    crm VARCHAR(20)
);

-- ========================================
-- Tabela: atendimentos
-- ========================================
CREATE TABLE atendimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    consultorio VARCHAR(20),
    status VARCHAR(20) DEFAULT 'aguardando',
    data_inicio DATETIME,
    data_fim DATETIME,

    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
);