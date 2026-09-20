@if($participants->count() > 0)

    <div class="table-responsive">

        <table class="table align-middle table-row-dashed">

            <thead>

                <tr class="text-muted fw-bold fs-7 text-uppercase">

                    <th width="5%">
                        #
                    </th>

                    <th>
                        Peserta
                    </th>

                    <th>
                        Kontak
                    </th>

                    <th>
                        Tanggal Daftar
                    </th>

                    <th class="text-center">
                        Status
                    </th>

                    <th class="text-end">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

            @foreach($participants as $index => $application)

                @php

                    $security = $application->security;

                    $number =
                        ($participants->currentPage() - 1)
                        * $participants->perPage()
                        + $index
                        + 1;


                    $statusClass = [
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    ][$application->status] ?? 'secondary';


                    $statusLabel = [
                        'pending' => 'Menunggu Persetujuan',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ][$application->status] ?? ucfirst(
                        $application->status
                    );


                    $photo = null;

                    if ($security && $security->formal_photo) {

                        $photo = $security->formal_photo;

                        if (
                            !preg_match(
                                '/^https?:\/\//',
                                $photo
                            )
                        ) {

                            if (
                                !str_starts_with(
                                    $photo,
                                    'storage/'
                                )
                            ) {

                                $photo = 'storage/' . ltrim(
                                    $photo,
                                    '/'
                                );

                            }

                            $photo = asset($photo);

                        }

                    }

                @endphp


                <tr>

                    {{-- NUMBER --}}

                    <td>

                        <span class="text-muted fw-semibold">

                            {{ $number }}

                        </span>

                    </td>


                    {{-- PARTICIPANT --}}

                    <td>

                        <div class="d-flex align-items-center">

                            <div class="symbol symbol-45px me-3">

                                @if($photo)

                                    <img
                                        src="{{ $photo }}"
                                        alt="{{ $security->name ?? 'Peserta' }}"
                                        class="object-fit-cover"
                                    >

                                @else

                                    <div class="symbol-label bg-light-primary">

                                        <i class="fas fa-user text-primary"></i>

                                    </div>

                                @endif

                            </div>


                            <div>

                                <div class="fw-bold text-gray-800">

                                    {{ $security->name ?? '-' }}

                                </div>

                                <div class="text-muted fs-8">

                                    {{ $security->registration_number ?? 'Nomor registrasi belum tersedia' }}

                                </div>

                            </div>

                        </div>

                    </td>


                    {{-- CONTACT --}}

                    <td>

                        <div class="fs-7">

                            @if($security?->email)

                                <div class="mb-1">

                                    <i class="fas fa-envelope text-muted me-1"></i>

                                    {{ $security->email }}

                                </div>

                            @endif


                            @if($security?->phone_number)

                                <div>

                                    <i class="fas fa-phone text-muted me-1"></i>

                                    {{ $security->phone_number }}

                                </div>

                            @endif

                        </div>

                    </td>


                    {{-- DATE --}}

                    <td>

                        <span class="text-muted fs-7">

                            {{ optional($application->created_at)->format('d M Y') }}

                        </span>

                        <div class="text-muted fs-8">

                            {{ optional($application->created_at)->format('H:i') }}

                        </div>

                    </td>


                    {{-- STATUS --}}

                    <td class="text-center">

                        <span class="badge badge-light-{{ $statusClass }}">

                            @if($application->status === 'pending')

                                <i class="fas fa-clock me-1"></i>

                            @elseif($application->status === 'approved')

                                <i class="fas fa-check me-1"></i>

                            @elseif($application->status === 'rejected')

                                <i class="fas fa-times me-1"></i>

                            @endif

                            {{ $statusLabel }}

                        </span>

                    </td>


                    {{-- ACTION --}}

                    <td class="text-end">

                        <a
                            href="{{ route(
                                'dashboard-user.training.participant.detail',
                                [
                                    $training->uuid,
                                    $application->uuid
                                ]
                            ) }}"
                            class="btn btn-outline-info btn-sm"
                            title="Detail Peserta"
                        >

                            <i class="fas fa-eye"></i>

                        </a>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>


    {{-- PAGINATION --}}

    <div class="d-flex justify-content-between align-items-center mt-5">

        <div class="text-muted fs-7">

            Menampilkan

            {{ $participants->firstItem() }}

            sampai

            {{ $participants->lastItem() }}

            dari

            {{ $participants->total() }}

            peserta

        </div>


        <div>

            {!! $participants->links() !!}

        </div>

    </div>


@else

    <div class="text-center py-15">

        <div class="mb-5">

            <i class="fas fa-users-slash fs-4x text-muted"></i>

        </div>

        <h4 class="fw-bold text-gray-700">

            Belum Ada Peserta

        </h4>

        <div class="text-muted fs-7">

            Belum ada peserta yang mendaftar pada pelatihan ini.

        </div>

    </div>

@endif