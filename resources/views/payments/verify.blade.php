@extends('layouts.app')

@section('content')

    <div class="col-md-12">
        <div class="card text-center w-75" style="margin: 10px auto 10px auto">
            <div class="card-header">
                Verify Payment
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Enter your OTP details to proceed
                </h5>
                <form class="card-text text-center" style="padding: 10px auto 10px auto" method="POST" action="{{route('payment.sendopt',['reference'=>$reference])}}">
                    {{ csrf_field() }}
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" placeholder="Enter OTP CODE"/>
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-primary">Verify</button>
                    </div>


                </form>
            </div>

        </div>


    </div>

    {{-- <script>
        // show hidden element
        const userEmail = document.getElementById("userEmail");
        const paymentMethod = document.getElementById("paymentMethod");
        const network_provider = document.getElementById("network_provider");

        paymentMethod.addEventListener('change', (event) => {
            if (event.target.value == 'card') {
                if (userEmail.style.display == 'none')
                {
                    userEmail.style.display = 'block';
                }

                network_provider.style.display='none';

            } else if(event.target.value == 'momo') {
                userEmail.style.display = 'none';
                network_provider.style.display='block';

            }
        });

        // increate =vote amount on onChange
        const voteCounts = document.getElementById("votesCounts");
        const totalDisplay = document.getElementById("totalAount");

        voteCounts.addEventListener('change', (event) => {
            totalDisplay.innerHTML = "Amount GHC " + event.target.value * {{ $unitCost }}
        });

    </script> --}}
@endsection
