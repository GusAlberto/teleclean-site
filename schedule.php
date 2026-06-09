<?php
$pageTitle = 'Agenda de Serviços | TeleClean';
$pageDescription = 'Agende lavagem, polimento e vitrificação com a TeleClean. Escolha data e horário disponível e confirme pelo WhatsApp.';
$canonicalUrl = 'https://www.teleclean.com.br/schedule.php';
$ogImage = 'assets/img/og-cover.jpg';
include __DIR__ . '/includes/head.php';
?>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="container" id="conteudo">
    <section class="section">
        <div class="section__heading">
            <span class="section__eyebrow">Agenda</span>
            <h1>Agende seu serviço</h1>
            <p>Escolha o serviço, selecione uma data e um horário disponível. Ao confirmar, será aberta uma mensagem no WhatsApp para finalizar o agendamento com nossa equipe.</p>
        </div>

        <div class="schedule-panel">
            <div class="schedule-controls">
                <label for="service-select">Serviço</label>
              <select id="service-select" class="schedule-select">
                <option>POLIMENTO TÉCNICO</option>
                <option>VITRIFICAÇÃO</option>
                <option>DETALHAMENTO AUTOMOTIVO</option>
                <option>HIGIENIZAÇÃO INTERNA</option>
                <option>LAVAGEM TÉCNICA</option>
                </select>
            </div>

            <div id="calendar" class="calendar"></div>
            <div id="timeslots" class="timeslots" hidden>
                <h3 id="timeslots-title"></h3>
                <div id="timeslot-list"></div>
                <button id="back-to-calendar" class="btn">Voltar</button>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script>
const WA_PHONE = '553135683754'; // WhatsApp com codigo de pais

async function fetchAppointments(){
  try{
    const r = await fetch('/api/appointments.php');
    return await r.json();
  }catch(e){
    return [];
  }
}

function startCalendar(){
  const calendar = document.getElementById('calendar');
  const timeslotsEl = document.getElementById('timeslots');
  const timeslotList = document.getElementById('timeslot-list');
  const timeslotsTitle = document.getElementById('timeslots-title');
  const backBtn = document.getElementById('back-to-calendar');
  const serviceSelect = document.getElementById('service-select');

  let appointments = [];
  let current = new Date();
  current.setDate(1);

  function formatDate(d){
    return d.toISOString().split('T')[0];
  }

  function render(){
    calendar.innerHTML = '';
    const header = document.createElement('div');
    header.className = 'calendar-header';
    const prev = document.createElement('button'); prev.textContent = '<';
    const next = document.createElement('button'); next.textContent = '>';
    const title = document.createElement('div'); title.textContent = current.toLocaleString('pt-BR',{month:'long', year:'numeric'});
    prev.onclick = ()=>{ current.setMonth(current.getMonth()-1); render(); };
    next.onclick = ()=>{ current.setMonth(current.getMonth()+1); render(); };
    header.appendChild(prev); header.appendChild(title); header.appendChild(next);
    calendar.appendChild(header);

    const grid = document.createElement('div'); grid.className='calendar-grid';
    const firstDay = new Date(current.getFullYear(), current.getMonth(), 1).getDay();
    const daysInMonth = new Date(current.getFullYear(), current.getMonth()+1, 0).getDate();

    // week days
    ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'].forEach(d=>{const w=document.createElement('div');w.className='calendar-weekday';w.textContent=d;grid.appendChild(w)});

    // blanks
    for(let i=0;i<firstDay;i++){ const b=document.createElement('div'); b.className='calendar-cell empty'; grid.appendChild(b); }

    for(let d=1; d<=daysInMonth; d++){
      const cell = document.createElement('button');
      cell.className='calendar-cell day';
      const date = new Date(current.getFullYear(), current.getMonth(), d);
      cell.textContent = d;
      const iso = formatDate(date);
      const hasAny = appointments.some(a=>a.startsWith(iso));
      if(hasAny) cell.classList.add('booked');
      cell.onclick = ()=>{
        showTimeslotsFor(date);
      };
      grid.appendChild(cell);
    }

    calendar.appendChild(grid);
  }

  function showTimeslotsFor(date){
    const iso = formatDate(date);
    timeslotsTitle.textContent = `Horários disponíveis para ${iso}`;
    timeslotList.innerHTML = '';
    // generate times 08:00 to 18:00 every 1h
    for(let h=8; h<=18; h++){
      const hh = String(h).padStart(2,'0') + ':00';
      const datetime = iso + 'T' + String(h).padStart(2,'0') + ':00:00';
      const busy = appointments.includes(datetime);
      const slot = document.createElement('div'); slot.className='timeslot';
      slot.textContent = hh + (busy ? ' — OCUPADO' : ' — DISPONÍVEL');
      if(!busy){
        const btn = document.createElement('button'); btn.className='btn btn--primary'; btn.textContent='Agendar';
        btn.onclick = ()=>{
          const service = encodeURIComponent(serviceSelect.value);
          const msg = encodeURIComponent(`Olá, quero agendar o serviço ${service} em ${iso} às ${hh}. Por favor, confirmar disponibilidade com os técnicos.`);
          window.open(`https://wa.me/${WA_PHONE}?text=${msg}`, '_blank');
        };
        slot.appendChild(btn);
      }
      timeslotList.appendChild(slot);
    }

    calendar.hidden = true;
    timeslotsEl.hidden = false;
  }

  backBtn.addEventListener('click', ()=>{ timeslotsEl.hidden=true; calendar.hidden=false; });

  fetchAppointments().then(data=>{ appointments = data; render(); });
}

document.addEventListener('DOMContentLoaded', startCalendar);
</script>

</body>
</html>
