/* ══════════════════════════════════════
   DADOS MOCK
   TODO: substituir por chamadas reais ao Laravel
══════════════════════════════════════ */
const MOCK_USERS = [
  { crm: 'SP-123456', senha: '1234', nome: 'Dr. Carlos Mendes' },
  { crm: 'RJ-654321', senha: '1234', nome: 'Dra. Ana Beatriz'  },
];

const patients = [
  { id:1, nome:'Ana Clara Oliveira',   idade:'34 anos', senha:'A001', chegada:'07:42', queixa:'Dor de cabeça intensa há 2 dias',         status:'em_atendimento', consultorio:'Consultório 02' },
  { id:2, nome:'João Pedro Santos',    idade:'58 anos', senha:'A002', chegada:'07:55', queixa:'Pressão alta, tontura e visão turva',      status:'chamado',        consultorio:'Consultório 01' },
  { id:3, nome:'Maria Fernanda Costa', idade:'27 anos', senha:'A003', chegada:'08:10', queixa:'Febre e tosse seca há 3 dias',             status:'aguardando',     consultorio:'' },
  { id:4, nome:'Carlos Eduardo Lima',  idade:'45 anos', senha:'A004', chegada:'08:22', queixa:'Dor lombar ao se movimentar',              status:'aguardando',     consultorio:'' },
  { id:5, nome:'Patricia Souza',       idade:'62 anos', senha:'A005', chegada:'08:35', queixa:'Consulta de rotina — diabetes',            status:'aguardando',     consultorio:'' },
  { id:6, nome:'Rafael Mendonça',      idade:'19 anos', senha:'A006', chegada:'08:48', queixa:'Dor de garganta e dificuldade ao engolir', status:'aguardando',     consultorio:'' },
  { id:7, nome:'Beatriz Almeida',      idade:'41 anos', senha:'A007', chegada:'09:00', queixa:'Retorno pós-operatório — avaliação',       status:'finalizado',     consultorio:'Consultório 03' },
];

/* ══════════════════════════════════════
   ESTADO DA APLICAÇÃO
══════════════════════════════════════ */
let currentFilter = 'all';
let editingId     = null;
let pollTimer     = null;
let pollSecs      = 15;
let sessionTimer  = null;
let sessionSecs   = 300;
let toastTimer    = null;

const POLL_INTERVAL = 15;

/* ══════════════════════════════════════
   TASK 24 — AUTENTICAÇÃO COM TOKEN/SESSÃO
══════════════════════════════════════ */
function generateToken(user) {
  const header  = btoa(JSON.stringify({ alg: 'HS256', typ: 'JWT' }));
  const payload = btoa(JSON.stringify({
    crm:  user.crm,
    nome: user.nome,
    iat:  Math.floor(Date.now() / 1000),
    exp:  Math.floor(Date.now() / 1000) + 300,
  }));
  return `${header}.${payload}.LARAVEL_SIGNATURE`;
}

function saveSession(user) {
  const token = generateToken(user);
  sessionStorage.setItem('med_token', token);
  sessionStorage.setItem('med_crm',   user.crm);
  sessionStorage.setItem('med_nome',  user.nome);
  sessionStorage.setItem('med_exp',   Date.now() + 300_000);
}

function clearSession() {
  ['med_token','med_crm','med_nome','med_exp'].forEach(k => sessionStorage.removeItem(k));
}

function isAuthenticated() {
  const token = sessionStorage.getItem('med_token');
  const exp   = parseInt(sessionStorage.getItem('med_exp') || '0');
  return !!token && Date.now() < exp;
}

function renewSession() {
  const crm  = sessionStorage.getItem('med_crm');
  const nome = sessionStorage.getItem('med_nome');
  if (!crm) return;
  saveSession({ crm, nome });
  sessionSecs = 300;
  document.getElementById('sessionWarning').classList.remove('show');
  showToast('Sessão renovada com sucesso!', 'success');
  /* TODO: POST /api/auth/refresh */
}

function startSessionTimer() {
  clearInterval(sessionTimer);
  sessionSecs  = 300;
  sessionTimer = setInterval(() => {
    sessionSecs--;
    if (sessionSecs <= 60) {
      const m = String(Math.floor(sessionSecs / 60)).padStart(2, '0');
      const s = String(sessionSecs % 60).padStart(2, '0');
      document.getElementById('sessionCountdown').textContent = `${m}:${s}`;
      document.getElementById('sessionWarning').classList.add('show');
    }
    if (sessionSecs <= 0) {
      clearInterval(sessionTimer);
      handleLogout();
      showToast('Sessão expirada. Faça login novamente.', 'warning');
    }
  }, 1000);
}

/* ══════════════════════════════════════
   TASK 37 — INTERCEPTOR DE ERROS
══════════════════════════════════════ */
async function apiFetch(url, options = {}) {
  /*
  TODO: implementação real com Laravel:

  const token = sessionStorage.getItem('med_token');
  const res   = await fetch(url, {
    ...options,
    headers: {
      'Authorization':  `Bearer ${token}`,
      'Content-Type':   'application/json',
      'Accept':         'application/json',
      ...options.headers,
    },
  });

  if (res.status === 401) { handleLogout(); showToast('Sessão expirada.', 'warning'); return null; }
  if (res.status === 403) { showToast('Sem permissão para esta ação.', 'error');       return null; }
  if (res.status >= 500)  { showToast('Erro no servidor. Tente novamente.', 'error');  return null; }
  if (!res.ok)            { showToast('Erro ao processar requisição.', 'error');        return null; }

  return res.json();
  */

  // Simulação de latência para desenvolvimento
  return new Promise(resolve => setTimeout(() => resolve({ ok: true, data: patients }), 250));
}

/* ══════════════════════════════════════
   TASK 31 — POLLING AUTOMÁTICO
══════════════════════════════════════ */
function startPolling() {
  stopPolling();
  pollSecs = POLL_INTERVAL;
  updatePollIndicator();

  pollTimer = setInterval(() => {
    pollSecs--;
    updatePollIndicator();
    if (pollSecs <= 0) {
      pollSecs = POLL_INTERVAL;
      fetchPatients(true); // silent = true: sem skeleton
    }
  }, 1000);
}

function stopPolling() {
  clearInterval(pollTimer);
}

function updatePollIndicator() {
  const el = document.getElementById('pollCountdown');
  if (el) el.textContent = `${pollSecs}s`;
}

async function fetchPatients(silent = false) {
  if (!silent) showLoadingSkeleton();
  try {
    const res = await apiFetch('/api/pacientes');
    if (res) renderList();
    else     showNetworkError();
  } catch {
    showNetworkError();
  }
}

/* ══════════════════════════════════════
   ESTADOS DA INTERFACE
══════════════════════════════════════ */
function showLoadingSkeleton() {
  document.getElementById('patientList').innerHTML = [1,2,3,4].map(() => `
    <div class="skeleton-row">
      <div><div class="skel circle"></div></div>
      <div><div class="skel"></div><div class="skel sm"></div></div>
      <div><div class="skel" style="width:50px"></div></div>
      <div><div class="skel"></div></div>
      <div><div class="skel" style="width:100px"></div></div>
      <div><div class="skel" style="width:140px"></div></div>
    </div>`).join('');
}

function showNetworkError() {
  document.getElementById('patientList').innerHTML = `
    <div class="state-box">
      <svg viewBox="0 0 24 24"><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/></svg>
      <h3>Sem conexão com o servidor</h3>
      <p>Exibindo últimos dados carregados.<br>Reconectando automaticamente…</p>
      <button onclick="fetchPatients()">Tentar novamente</button>
    </div>`;
}

function showEmptyState(filter) {
  const labels = {
    all:            'nenhum paciente cadastrado',
    aguardando:     'nenhum paciente aguardando',
    chamado:        'nenhum paciente chamado',
    em_atendimento: 'nenhum paciente em atendimento',
    finalizado:     'nenhum atendimento finalizado',
  };
  document.getElementById('patientList').innerHTML = `
    <div class="state-box">
      <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
      <h3>Fila vazia</h3>
      <p>Há ${labels[filter] || 'nenhum resultado'} no momento.<br>A lista atualiza automaticamente a cada ${POLL_INTERVAL}s.</p>
    </div>`;
}

/* ══════════════════════════════════════
   RENDER DA LISTA
══════════════════════════════════════ */
function statusInfo(s) {
  return {
    aguardando:     ['s-waiting',   '⏱ Aguardando'],
    chamado:        ['s-called',    '📢 Chamado'],
    em_atendimento: ['s-attending', '🩺 Em atendimento'],
    finalizado:     ['s-done',      '✔ Finalizado'],
  }[s] || ['s-waiting', s];
}

function renderList() {
  const filtered = currentFilter === 'all'
    ? patients
    : patients.filter(p => p.status === currentFilter);

  if (!filtered.length) { showEmptyState(currentFilter); updateStats(); return; }

  document.getElementById('patientList').innerHTML = filtered.map((p, i) => {
    const [cls, lbl] = statusInfo(p.status);
    return `
      <div class="pt-row" onclick="openModal(${p.id})">
        <div><div class="pos-badge">${i + 1}</div></div>
        <div><div class="pt-name">${esc(p.nome)}</div><div class="pt-sub">${esc(p.idade)}</div></div>
        <div style="font-weight:700;color:#2c3e50">${esc(p.senha)}</div>
        <div class="col-q"><div class="queixa" title="${esc(p.queixa)}">${esc(p.queixa)}</div></div>
        <div><span class="status-badge ${cls}">${lbl}</span></div>
        <div class="col-a actions">${buildActions(p)}</div>
      </div>`;
  }).join('');

  updateStats();
}

function buildActions(p) {
  let b = '';
  if (p.status === 'aguardando')     b += `<button class="act-btn act-call"  onclick="quickAction(event,${p.id},'chamado')">📢 Chamar</button>`;
  if (p.status === 'chamado')        b += `<button class="act-btn act-start" onclick="quickAction(event,${p.id},'em_atendimento')">▶ Atender</button>`;
  if (p.status === 'em_atendimento') b += `<button class="act-btn act-done"  onclick="quickAction(event,${p.id},'finalizado')">✔ Finalizar</button>`;
  b += `<button class="act-btn act-view" onclick="openModal(${p.id});event.stopPropagation()">👁 Ver</button>`;
  return b;
}

function updateStats() {
  document.getElementById('statTotal').textContent     = patients.length;
  document.getElementById('statWaiting').textContent   = patients.filter(p => p.status === 'aguardando').length;
  document.getElementById('statAttending').textContent = patients.filter(p => p.status === 'em_atendimento').length;
  document.getElementById('statDone').textContent      = patients.filter(p => p.status === 'finalizado').length;
}

function setFilter(f, btn) {
  currentFilter = f;
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderList();
}

/* ══════════════════════════════════════
   AÇÕES RÁPIDAS (otimistic update)
══════════════════════════════════════ */
async function quickAction(e, id, newStatus) {
  e.stopPropagation();
  const p = patients.find(x => x.id === id);
  if (!p) return;

  const oldStatus = p.status;
  p.status = newStatus; // atualização otimista
  renderList();

  /* TODO: PATCH /api/pacientes/{id}/status */
  const ok = await apiFetch(`/api/pacientes/${id}/status`, {
    method: 'PATCH',
    body:   JSON.stringify({ status: newStatus }),
  });

  if (!ok) {
    p.status = oldStatus; // rollback
    renderList();
    showToast('Erro ao atualizar status. Tente novamente.', 'error');
    return;
  }

  const msgs = {
    chamado:        `${p.nome} foi chamado(a)!`,
    em_atendimento: `Atendimento de ${p.nome} iniciado`,
    finalizado:     `Atendimento de ${p.nome} finalizado`,
  };
  showToast(msgs[newStatus] || 'Status atualizado', 'success');
}

/* ══════════════════════════════════════
   MODAL DE DETALHES
══════════════════════════════════════ */
function openModal(id) {
  const p = patients.find(x => x.id === id);
  if (!p) return;
  editingId = id;

  document.getElementById('mName').textContent        = p.nome;
  document.getElementById('mSenha').textContent       = p.senha;
  document.getElementById('mChegada').textContent     = p.chegada;
  document.getElementById('mIdade').textContent       = p.idade;
  document.getElementById('mConsultorio').textContent = p.consultorio || '—';
  document.getElementById('mQueixa').textContent      = p.queixa;
  document.getElementById('mStatus').value            = p.status;
  document.getElementById('mConsultorioSel').value    = p.consultorio || '';
  document.getElementById('modal').style.display      = 'flex';
}

function closeModal() {
  document.getElementById('modal').style.display = 'none';
  editingId = null;
}

async function saveModal() {
  const p = patients.find(x => x.id === editingId);
  if (!p) return;

  p.status = document.getElementById('mStatus').value;
  const c  = document.getElementById('mConsultorioSel').value;
  if (c) p.consultorio = c;

  closeModal();
  renderList();
  showToast('Paciente atualizado com sucesso!', 'success');
  /* TODO: PATCH /api/pacientes/{id} */
}

/* ══════════════════════════════════════
   LOGIN / LOGOUT
══════════════════════════════════════ */
async function handleLogin() {
  const crm   = document.getElementById('crm').value.trim().toUpperCase();
  const senha = document.getElementById('senha').value.trim();
  const err   = document.getElementById('errorMsg');
  const errTx = document.getElementById('errorText');
  const btn   = document.getElementById('btnLogin');

  if (!crm || !senha) {
    errTx.textContent = 'Preencha o CRM e a senha para continuar.';
    err.classList.add('show');
    return;
  }

  err.classList.remove('show');
  btn.textContent = 'Autenticando…';
  btn.classList.add('loading');
  btn.disabled = true;

  /* TODO: POST /api/auth/login { crm, password } */
  await new Promise(r => setTimeout(r, 600));
  const user = MOCK_USERS.find(u => u.crm === crm && u.senha === senha);

  if (!user) {
    errTx.textContent = 'CRM ou senha inválidos. Tente novamente.';
    err.classList.add('show');
    btn.textContent = 'Entrar';
    btn.classList.remove('loading');
    btn.disabled = false;
    return;
  }

  saveSession(user);
  initDashboard(user.nome);
}

function initDashboard(nome) {
  document.getElementById('docName').textContent        = nome;
  document.getElementById('screen-login').style.display = 'none';
  document.getElementById('screen-dash').style.display  = 'flex';
  document.getElementById('btnLogin').textContent       = 'Entrar';
  document.getElementById('btnLogin').classList.remove('loading');
  document.getElementById('btnLogin').disabled          = false;

  fetchPatients();
  startPolling();
  startSessionTimer();
  showToast(`Bem-vindo(a), ${nome}!`, 'success');
}

function handleLogout() {
  stopPolling();
  clearInterval(sessionTimer);
  clearSession();

  document.getElementById('screen-dash').style.display  = 'none';
  document.getElementById('screen-login').style.display = 'flex';
  document.getElementById('sessionWarning').classList.remove('show');
  document.getElementById('crm').value   = '';
  document.getElementById('senha').value = '';
}

/* ══════════════════════════════════════
   TOGGLE SENHA
══════════════════════════════════════ */
function toggleSenha() {
  const input = document.getElementById('senha');
  const icon  = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
  }
}

/* ══════════════════════════════════════
   TOAST
══════════════════════════════════════ */
function showToast(msg, type = '') {
  if (toastTimer) clearTimeout(toastTimer);
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className   = `toast ${type}`;
  void t.offsetWidth;
  t.classList.add('show');
  toastTimer = setTimeout(() => t.classList.remove('show'), 3200);
}

/* ══════════════════════════════════════
   UTILITÁRIOS
══════════════════════════════════════ */
function esc(str) {
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

/* ══════════════════════════════════════
   EVENTOS GLOBAIS
══════════════════════════════════════ */
document.getElementById('modal').addEventListener('click', e => {
  if (e.target === document.getElementById('modal')) closeModal();
});

document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeModal();
});

// Recarregamento com sessão ativa
window.addEventListener('load', () => {
  if (isAuthenticated()) {
    initDashboard(sessionStorage.getItem('med_nome'));
  }
});
