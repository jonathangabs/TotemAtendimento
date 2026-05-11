-- ========================================
-- SEED - DADOS INICIAIS E TESTES
-- Projeto: TotemAtendimento
-- ========================================

USE clinica;

-- ========================================
-- INSERÇÃO DE MÉDICOS
-- ========================================
INSERT INTO medicos (nome, email, senha, especialidade, telefone)
VALUES 
('Dr. João Silva', 'joao@clinica.com', '123456', 'Clínico Geral', '11999990001'),
('Dra. Ana Souza', 'ana@clinica.com', '123456', 'Pediatria', '11999990002');

-- ========================================
-- INSERÇÃO DE PACIENTES
-- ========================================
INSERT INTO pacientes (nome, cpf, telefone, senha)
VALUES 
('Maria Silva', '123.456.789-00', '11988880001', 1),
('Carlos Oliveira', '987.654.321-00', '11988880002', 2);

-- ========================================
-- ENDEREÇOS
-- ========================================
INSERT INTO enderecos (paciente_id, cep, logradouro, numero, bairro, cidade)
VALUES
(1, '01000-000', 'Rua A', '100', 'Centro', 'São Paulo'),
(2, '02000-000', 'Rua B', '200', 'Zona Norte', 'São Paulo');

-- ========================================
-- INFORMAÇÕES MÉDICAS
-- ========================================
INSERT INTO informacoes_medicas (paciente_id, tipo_sanguineo, alergias)
VALUES
(1, 'O+', 'Nenhuma'),
(2, 'A-', 'Penicilina');

-- ========================================
-- ATENDIMENTOS (FILA)
-- ========================================
INSERT INTO atendimentos (paciente_id, medico_id, consultorio, status)
VALUES
(1, 1, '101', 'aguardando'),
(2, 2, '102', 'aguardando');

-- ========================================
-- CONSULTAS (SELECT)
-- ========================================

-- Lista pacientes
SELECT * FROM pacientes;

-- Lista médicos
SELECT * FROM medicos;

-- Lista atendimentos com dados completos
SELECT 
    a.id,
    p.nome AS paciente,
    m.nome AS medico,
    a.status,
    a.consultorio
FROM atendimentos a
JOIN pacientes p ON a.paciente_id = p.id
JOIN medicos m ON a.medico_id = m.id;

-- ========================================
-- ATUALIZAÇÕES (FLUXO REAL)
-- ========================================

-- Chamar paciente 1
UPDATE atendimentos
SET status = 'chamado'
WHERE id = 1;

-- Em atendimento
UPDATE atendimentos
SET status = 'em_atendimento'
WHERE id = 1;

-- Finalizar atendimento
UPDATE atendimentos
SET status = 'finalizado'
WHERE id = 1;

-- Atualizar telefone de paciente
UPDATE pacientes
SET telefone = '11977770000'
WHERE id = 1;

-- ========================================
-- VERIFICAÇÃO FINAL
-- ========================================

SELECT * FROM atendimentos;