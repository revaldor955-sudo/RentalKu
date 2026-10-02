<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Balasan RentalKu</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f4f7f6;
    font-family: Arial, Helvetica, sans-serif;
">

    <div style="
        max-width: 650px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    ">

        {{-- Header --}}
        <div style="
            background: #2c666e;
            padding: 30px;
            text-align: center;
        ">

            <h1 style="
                color: #ffffff;
                margin: 0;
                font-size: 28px;
            ">
                Rental<span style="color: #7de2a8;">ku</span>.
            </h1>

            <p style="
                color: #e8f5f2;
                margin: 8px 0 0;
                font-size: 14px;
            ">
                Rental Mobil Terpercaya
            </p>

        </div>


        {{-- Content --}}
        <div style="
            padding: 35px;
        ">

            <h2 style="
                color: #172033;
                margin-top: 0;
            ">
                Halo {{ $contact->nama }},
            </h2>

            <p style="
                color: #5f6b7a;
                line-height: 1.7;
            ">
                Terima kasih telah menghubungi RentalKu.
                Berikut adalah balasan dari tim kami mengenai pesan Anda.
            </p>


            {{-- Subject --}}
            <div style="
                background: #f5f8f7;
                padding: 18px;
                border-radius: 10px;
                margin: 25px 0;
            ">

                <strong style="color: #172033;">
                    Subjek:
                </strong>

                <div style="
                    margin-top: 6px;
                    color: #5f6b7a;
                ">
                    {{ $contact->subjek }}
                </div>

            </div>


            {{-- Balasan --}}
            <div style="
                border-left: 4px solid #2c666e;
                padding: 15px 20px;
                margin: 25px 0;
                background: #f8faf9;
            ">

                <strong style="
                    color: #172033;
                ">
                    Balasan Tim RentalKu
                </strong>

                <p style="
                    color: #5f6b7a;
                    line-height: 1.8;
                    white-space: pre-line;
                    margin-bottom: 0;
                ">
                    {{ $balasan }}
                </p>

            </div>


            <p style="
                color: #5f6b7a;
                line-height: 1.7;
            ">
                Jika masih ada pertanyaan lainnya, silakan hubungi
                kami kembali melalui website RentalKu.
            </p>


            <p style="
                color: #172033;
                margin-top: 30px;
            ">
                Terima kasih,<br>
                <strong>Tim RentalKu</strong>
            </p>

        </div>


        {{-- Footer --}}
        <div style="
            background: #f4f7f6;
            padding: 20px;
            text-align: center;
            color: #7a8491;
            font-size: 13px;
        ">

            © {{ date('Y') }} RentalKu.
            Semua hak dilindungi.

        </div>

    </div>

</body>

</html>