<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="flex justify-center">
  <div class="calculator relative w-full max-w-md overflow-hidden rounded-[32px] border border-slate-900/10 bg-[linear-gradient(180deg,_rgba(15,23,42,0.96),_rgba(30,41,59,0.94))] p-5 shadow-[0_25px_60px_-25px_rgba(15,23,42,0.95)] ring-1 ring-white/10 backdrop-blur-xl sm:p-6">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-24 bg-[radial-gradient(circle_at_top,_rgba(125,211,252,0.28),_transparent_65%)]"></div>
    <div class="pointer-events-none absolute -right-16 -top-20 h-56 w-56 rounded-full bg-blue-400/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-10 bottom-0 h-40 w-40 rounded-full bg-cyan-400/10 blur-3xl"></div>

    <div class="relative mb-5 rounded-[26px] border border-white/10 bg-white/6 p-4 text-right shadow-[inset_0_1px_0_rgba(255,255,255,0.08)]">
      <div class="mb-4 flex items-center justify-between text-xs uppercase tracking-[0.28em] text-slate-400">
        <span>Live Result</span>
        <span class="rounded-full border border-white/10 bg-white/6 px-2.5 py-1 text-[10px] font-semibold tracking-[0.22em] text-cyan-200">Ready</span>
      </div>
      <div id="history" class="min-h-6 break-all font-medium text-slate-400">0</div>
      <div id="display" class="origin-right min-h-16 break-all pt-3 text-[clamp(2.35rem,5vw,3.65rem)] font-black leading-none tracking-tight text-white">
        0
      </div>
    </div>

    <div class="relative grid grid-cols-4 gap-3">
      <button class="calc-btn calc-fade h-16 rounded-[22px] border border-rose-400/20 bg-rose-400/12 font-semibold text-rose-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-rose-400/20 active:scale-95" data-action="clear">AC</button>
      <button class="calc-btn calc-fade h-16 rounded-[22px] border border-amber-300/20 bg-amber-300/12 font-semibold text-amber-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-amber-300/20 active:scale-95" data-action="delete">DEL</button>
      <button class="calc-btn calc-fade h-16 rounded-[22px] border border-white/10 bg-white/8 font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="%">%</button>
      <button class="calc-btn h-16 rounded-[22px] bg-[linear-gradient(135deg,_rgba(56,189,248,0.95),_rgba(37,99,235,0.95))] font-bold text-white shadow-[0_18px_28px_-18px_rgba(59,130,246,0.95)] transition duration-200 hover:-translate-y-0.5 hover:brightness-110 active:scale-95" data-value="/">&divide;</button>

      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="7">7</button>
      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="8">8</button>
      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="9">9</button>
      <button class="calc-btn h-16 rounded-[22px] bg-[linear-gradient(135deg,_rgba(59,130,246,0.95),_rgba(124,58,237,0.95))] font-bold text-white shadow-[0_18px_28px_-18px_rgba(99,102,241,0.95)] transition duration-200 hover:-translate-y-0.5 hover:brightness-110 active:scale-95" data-value="*">&times;</button>

      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="4">4</button>
      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="5">5</button>
      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="6">6</button>
      <button class="calc-btn h-16 rounded-[22px] bg-[linear-gradient(135deg,_rgba(79,70,229,0.95),_rgba(168,85,247,0.95))] font-bold text-white shadow-[0_18px_28px_-18px_rgba(129,140,248,0.95)] transition duration-200 hover:-translate-y-0.5 hover:brightness-110 active:scale-95" data-value="-">&minus;</button>

      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="1">1</button>
      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="2">2</button>
      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="3">3</button>
      <button class="calc-btn h-16 rounded-[22px] bg-[linear-gradient(135deg,_rgba(14,165,233,0.95),_rgba(99,102,241,0.95))] font-bold text-white shadow-[0_18px_28px_-18px_rgba(56,189,248,0.95)] transition duration-200 hover:-translate-y-0.5 hover:brightness-110 active:scale-95" data-value="+">+</button>

      <button class="calc-btn col-span-2 h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value="0">0</button>
      <button class="calc-btn h-16 rounded-[22px] border border-white/10 bg-white/8 text-lg font-semibold text-slate-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.08)] transition duration-200 hover:-translate-y-0.5 hover:bg-white/12 active:scale-95" data-value=".">.</button>
      <button class="calc-btn h-16 rounded-[22px] bg-[linear-gradient(135deg,_rgba(34,197,94,0.98),_rgba(6,182,212,0.95))] font-bold text-white shadow-[0_22px_32px_-18px_rgba(16,185,129,0.95)] transition duration-200 hover:-translate-y-0.5 hover:brightness-110 active:scale-95" data-action="calculate">=</button>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
