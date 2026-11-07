@extends('layouts.user-page')

@section('title', 'Notifikasi')

@section('content')
    <div class="container-xxl">
        @include('user-page.notif.partials.breadcrumb')

        <div class="row g-4">

            <!-- Sidebar Kiri (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">
                
            </div>

            <!-- Content (Selalu Tampil) -->
            <div class="col-12 col-lg-8">
                @include('user-page.notif.partials.content')
            </div>

            <!-- Sidebar Kanan (Desktop Only) -->
            <div class="d-none d-lg-block col-lg-2">

            </div>

        </div>
    </div>

@endsection
@section('js')
<script>
    $('#btnReadAll').on('click', function() {

        const button = $(this);

        Swal.fire({
            title: 'Tandai semua dibaca?',
            text: 'Semua notifikasi Anda akan ditandai sebagai sudah dibaca.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, tandai semua',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#f7b003',
            cancelButtonColor: '#6c757d',
        }).then((result) => {

            if (!result.isConfirmed) {
                return;
            }

            button.prop('disabled', true);

            $.ajax({
                url: "{{ route('user-page.notif.read-all') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });

                },

                error: function(xhr) {

                    button.prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui notifikasi.'
                    });

                }
            });

        });

    });
</script>
@endsection