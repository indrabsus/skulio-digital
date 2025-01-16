<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Soal Sumatif</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1, h4 {
            text-align: center;
        }
        hr {
            margin: 20px 0;
        }
        .question {
            margin-bottom: 20px;
        }
        .question img {
            margin-top: 10px;
        }
        .options {
            list-style-type: none;
            padding-left: 0;
        }
        .options li {
            margin-bottom: 10px;
        }
        .option-image {
            margin-top: 5px;
        }
        .correct {
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
    <h1>Soal Sumatif</h1>
    <h4>Nama Soal: {{ $detail->nama_soal }}</h4>
    <h4>Guru: {{ $detail->nama_lengkap }}</h4>
    <hr>

    @php $no = 1; @endphp

    @foreach ($soal as $d)
        @php
            $opsi = App\Models\Opsi::where('id_soal', $d->id_soal)->get();
        @endphp
        <div class="question">
            <strong>{{ $no++ }}. {{ $d->soal }}</strong>
            @if ($d->gambar)
                <div>
                    <img src="{{ asset('storage/'.$d->gambar) }}" alt="Gambar Soal" width="300px">
                </div>
            @endif
            <ul class="options">
                @foreach ($opsi as $o)
                    <li>
                        {{ $o->opsi }}
                        @if ($o->benar == 1)
                            <span class="correct">(Benar)</span>
                        @endif
                        @if ($o->opsi_gambar)
                            <div class="option-image">
                                <img src="{{ asset('storage/'.$o->opsi_gambar) }}" alt="Gambar Opsi" width="150px">
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</body>
</html>
