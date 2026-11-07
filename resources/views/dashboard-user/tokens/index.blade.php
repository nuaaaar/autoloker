@extends('layouts.dashboard-user')

@section('title', 'Saldo token')

@section('css')
    @include('partials.token-billing-styles')
@endsection

@section('breadcrumb')
    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Saldo token</h1>
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
        <li class="breadcrumb-item text-muted">Beranda</li>
        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
        <li class="breadcrumb-item text-muted">Saldo token</li>
    </ul>
@endsection

@section('content')
    <div class="token-billing-content">
    @if(session('OK'))
        <div class="alert alert-success" role="status">{{ session('OK') }}</div>
    @endif
    @if(session('ERR'))
        <div class="alert alert-warning" role="status">{{ session('ERR') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="mb-1">Pesanan tidak dapat diproses.</p>
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    @if($banks->isNotEmpty())
        <section class="card mb-5" aria-labelledby="bank-details-heading">
            <div class="card-body">
                <h2 id="bank-details-heading" class="fs-5 fw-bold text-gray-900 mb-3">Rekening tujuan transfer</h2>
                <div class="row g-4">
                    @foreach($banks as $bank)
                        <div class="col-12 col-md-6 col-xl-4">
                            <p class="mb-0"><strong>{{ strtoupper($bank->bank_name) }}</strong><br>{{ $bank->bank_number }}<br>{{ $bank->account_name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <div class="alert alert-warning" role="status">Rekening tujuan transfer belum tersedia. Hubungi admin sebelum membuat pembayaran.</div>
    @endif

    <div class="row g-5">
        <div class="col-12 col-xl-5">
            <section class="card h-100" aria-labelledby="wallet-heading">
                <div class="card-body p-6 p-lg-8">
                    <h2 id="wallet-heading" class="fs-4 fw-bold text-gray-900 mb-2">Saldo organisasi</h2>
                    <p class="text-muted mb-5">Token milik organisasi ini dan tidak kedaluwarsa.</p>
                    <p class="display-5 fw-bold text-gray-900 mb-0">{{ number_format($wallet->balance, 0, ',', '.') }} <span class="fs-5 fw-semibold">token</span></p>
                    <hr class="my-6">
                    <h3 class="fs-5 fw-bold text-gray-900 mb-4">Isi saldo</h3>
                    <form method="POST" action="{{ route('dashboard-user.tokens.orders.store') }}">
                        @csrf
                        <label for="token_quantity" class="form-label fw-semibold">Jumlah token</label>
                        <input id="token_quantity" name="token_quantity" type="number" class="form-control form-control-lg" min="1" step="1" value="{{ old('token_quantity', 1) }}" required aria-describedby="token-price-help">
                        <div id="token-price-help" class="form-text">1 token = Rp {{ number_format($settings->idr_per_token, 0, ',', '.') }}. Token tidak kedaluwarsa.</div>
                        <p class="mt-3 mb-5">Total pembayaran: <output id="token-order-total" for="token_quantity" data-rate="{{ $settings->idr_per_token }}">Rp {{ number_format($settings->idr_per_token, 0, ',', '.') }}</output></p>
                        <button type="submit" class="btn btn-warning fw-semibold w-100" @disabled($banks->isEmpty())>Buat pesanan pengisian token</button>
                    </form>
                </div>
            </section>
        </div>
        <div class="col-12 col-xl-7">
            <section class="card mb-5" aria-labelledby="orders-heading">
                <div class="card-header"><h2 id="orders-heading" class="card-title fs-4 fw-bold">Pesanan pengisian</h2></div>
                <div class="card-body">
                    @forelse($orders as $order)
                        <article class="border rounded p-4 mb-4">
                            <div class="d-flex flex-wrap justify-content-between gap-2">
                                <div><h3 class="fs-6 fw-bold mb-1">{{ $order->order_number ?? 'Pesanan' }}</h3><p class="text-muted mb-1">{{ number_format($order->token_quantity ?? 0, 0, ',', '.') }} token · Rp {{ number_format($order->price, 0, ',', '.') }}</p></div>
                                <span class="badge badge-light-secondary align-self-start">{{ match ($order->status) {
                                    'pending_payment' => 'Menunggu pembayaran',
                                    'verification' => 'Menunggu verifikasi',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    'cancelled' => 'Dibatalkan',
                                    default => $order->status,
                                } }}</span>
                            </div>
                            @php
                                $orderCanBePaid = $order->expired_at === null || $order->expired_at->isFuture();
                            @endphp
                            @if(in_array($order->status, ['pending_payment', 'rejected'], true) && $orderCanBePaid)
                                @if($order->status === 'rejected' && $order->rejected_reason)
                                    <p class="alert alert-danger mt-3 mb-0" role="alert">Pembayaran ditolak: {{ $order->rejected_reason }}</p>
                                @endif
                                <form class="mt-3" method="POST" enctype="multipart/form-data" action="{{ route('dashboard-user.tokens.orders.upload-proof', $order->uuid) }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="payment-method-{{ $order->uuid }}">Metode pembayaran</label>
                                            <select id="payment-method-{{ $order->uuid }}" name="payment_method" class="form-select" required>
                                                <option value="">Pilih bank tujuan</option>
                                                @foreach($banks as $bank)
                                                    <option value="{{ $bank->bank_name }}">{{ strtoupper($bank->bank_name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="payment-date-{{ $order->uuid }}">Tanggal pembayaran</label>
                                            <input id="payment-date-{{ $order->uuid }}" name="payment_date" type="date" class="form-control" max="{{ now()->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="payment-account-{{ $order->uuid }}">Rekening pengirim atau keterangan <span class="text-muted">(opsional)</span></label>
                                            <input id="payment-account-{{ $order->uuid }}" name="payment_account" type="text" class="form-control" maxlength="255">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="payment-proof-{{ $order->uuid }}">Bukti transfer (JPG, PNG, atau PDF, maksimal 5 MB)</label>
                                            <input id="payment-proof-{{ $order->uuid }}" name="payment_proof" type="file" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-warning" type="submit">Kirim bukti pembayaran</button>
                                        </div>
                                    </div>
                                </form>
                            @elseif(in_array($order->status, ['pending_payment', 'rejected'], true))
                                <p class="text-danger mt-3 mb-0">Batas pembayaran pesanan ini telah berakhir.</p>
                            @elseif($order->status === 'verification')
                                <p class="text-muted mb-0 mt-3">Bukti diterima. Saldo bertambah setelah admin menyetujui pembayaran.</p>
                            @endif
                            @if($order->status === 'pending_payment')
                                <form method="POST" action="{{ route('dashboard-user.tokens.orders.cancel', $order->uuid) }}" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Batalkan pesanan</button>
                                </form>
                            @endif
                        </article>
                    @empty
                        <p class="text-muted mb-0">Belum ada pesanan pengisian. Buat pesanan untuk mulai menambah saldo organisasi.</p>
                    @endforelse
                    {{ $orders->links() }}
                </div>
            </section>
            <section class="card" aria-labelledby="ledger-heading">
                <div class="card-header"><h2 id="ledger-heading" class="card-title fs-4 fw-bold">Riwayat token</h2></div>
                <div class="card-body">
                    @forelse($transactions as $transaction)
                        <div class="d-flex flex-wrap justify-content-between gap-2 border-bottom py-3">
                            <div><div class="fw-semibold text-gray-900">{{ match ($transaction->kind) {
                                'topup' => 'Pengisian token',
                                'job_publication' => 'Publikasi lowongan',
                                'training_publication' => 'Publikasi pelatihan',
                                default => $transaction->kind,
                            } }}</div><time class="text-muted" datetime="{{ $transaction->created_at->toIso8601String() }}">{{ $transaction->created_at->format('d M Y H:i') }}</time></div>
                            <div class="text-end"><div class="fw-bold">{{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 0, ',', '.') }} token</div><small class="text-muted">Saldo: {{ number_format($transaction->balance_after, 0, ',', '.') }}</small></div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Transaksi token organisasi akan muncul di sini setelah pengisian disetujui atau publikasi dilakukan.</p>
                    @endforelse
                    {{ $transactions->links() }}
                </div>
            </section>
        </div>
    </div>
    </div>
    <script>
        const tokenQuantity = document.getElementById('token_quantity');
        const tokenTotal = document.getElementById('token-order-total');

        if (tokenQuantity && tokenTotal) {
            const formatTokenTotal = () => {
                const quantity = Number(tokenQuantity.value);
                const rate = Number(tokenTotal.dataset.rate);
                const total = quantity > 0 ? quantity * rate : rate;
                tokenTotal.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
            };

            tokenQuantity.addEventListener('input', formatTokenTotal);
            formatTokenTotal();
        }
    </script>
@endsection
