<div>
<style>
 /* Primary colors */
:root {
    --light-red: hsl(0, 100%, 67%);
    --orange-yellow: hsl(39, 100%, 56%);
    --green-teal: hsl(166, 100%, 37%);
    --cobalt-blue: hsl(234, 85%, 45%);

    /* Gradient colors */
    --light-slate-blue: rgb(3, 45, 112);
    --light-royal-blue: rgb(57,131,254);
    --violet-blue: hsla(256, 72%, 46%, 1);
    --persian-blue: hsla(241, 72%, 46%, 0);

    /* Neutral colors */
    --white: hsl(0, 0%, 100%);
    --pale-blue: hsl(221, 100%, 96%);
    --light-lavendar: hsl(241, 100%, 89%);
    --dark-gray-blue: hsl(224, 30%, 27%);
}

body {
    font-family: 'Hanken Grotesk', sans-serif;
    width: 100%;
    height: auto;
}

main {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    display: flex;
    flex-direction: column;
    background-color: var(--white);
    box-shadow: 4px 4px 25px 0px #dadada;
    border-radius: 0px;
    width: 100%;
}

.card-left {
    background: linear-gradient(to bottom, var(--light-slate-blue) 0% 20%, var(--light-royal-blue));
    border-radius: 0px 0px 15px 15px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    row-gap: 20px;
    width: 100%;
}

.card-left h4 {
    color: var(--light-lavendar);
    text-align: center;
    font-size: 20px;
}

.score {
    background: linear-gradient(to bottom, var(--violet-blue), var(--light-royal-blue), var(--light-slate-blue));
    width: 150px;
    height: 150px;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.score h1 {
    font-size: 50px;
    color: var(--white);
}

.score span {
    color: var(--light-lavendar);
}

.score-content h2 {
    font-size: 30px;
    color: var(--white);
    text-align: center;
}

.score-content p {
    margin-top: 12px;
    color: var(--light-lavendar);
    text-align: center;
}

.card-right {
    padding: 30px;
    display: flex;
    flex-direction: column;
    row-gap: 20px;
    width: 100%;
}

.card-right h2 {
    color: var(--dark-gray-blue);
}

.card-right ul {
    list-style-type: none;
    display: flex;
    flex-direction: column;
    row-gap: 12px;
}

.card-right ul li {
    display: flex;
    justify-content: space-between;
    padding: 12px;
    border-radius: 5px;
}

.card-right ul li:nth-of-type(1) {
    background: hsl(0, 100%, 67%, 0.1);
}

.card-right ul li:nth-of-type(1) p {
    color: var(--light-red);
}

.card-right ul li:nth-of-type(2) {
    background: hsl(39, 100%, 56%, 0.1);
}

.card-right ul li:nth-of-type(2) p {
    color: var(--orange-yellow);
}

.card-right ul li:nth-of-type(3) {
    background: hsl(166, 100%, 37%, 0.1);
}

.card-right ul li:nth-of-type(3) p {
    color: var(--green-teal);
}

.card-right ul li:nth-of-type(4) {
    background: hsl(234, 85%, 45%, 0.1);
}

.card-right ul li:nth-of-type(4) p {
    color: var(--cobalt-blue);
}

.li-left {
    display: flex;
    column-gap: 10px;
}

.li-left p {
    font-weight: 500;
}

.li-right p {
    color: var(--light-lavendar);
}

.li-right p b {
    color: var(--dark-gray-blue);
}

.card-right a {
    background: blue;
    padding: 12px;
    text-align: center;
    color: var(--white);
    text-decoration: none;
    font-size: 18px;
    border-radius: 30px;
}

.card-right a:hover {
    background: linear-gradient(to bottom, var(--light-slate-blue) 0% 20%, var(--light-royal-blue));
}

@media (min-width: 550px) {
    body {
        height: 100vh;
    }

    main .card {
        flex-direction: row;
        width: 850px;
        border-radius: 15px;
    }

    .card-left {
        width: 50%;
        border-radius: 15px;
    }

    .card-right {
        width: 50%;
    }
}

    </style>

    <main>
        <div class="card mt-2">
            <div class="card-left">
                <h4><b>{{$users->username}}</b></h4>

               

             <span><b style="color: #c8c7ff;">Register ID : {{$users->registerid}}</b></span>
             @foreach ($roles as $item)
             @if($item->id == $users->roleid)
             <span><b style="color: #c8c7ff;">Role: {{$item->role}}</b></span>
             @endif
             @endforeach 

                <div class="score">
                    <img src="{{asset('images/'.$users->file)}}" alt="image" style="width: 130px; height:130px; border:1px solid #c8c7ff; border-radius:100%; padding:5px; "/>
                </div>
                <div class="score-content">
                    <h5 style="color: #c8c7ff;">Email ID: {{$users->email}}</h5>
                    <p>Contact No. : {{$users->contactno}}</p>
                </div>
            </div>
            <div class="card-right">
                <h2><b>Summary</b></h2>
                <ul class="summary-lists">
                    <li>
                        <div class="li-left">
                            <p><b>Farm Name :</b> {{$users->framname}}</p>
                        </div>
                    </li>
                    <li>
                        <div class="li-left">
                            <p><b>Address :</b>  {{$users->address}}, {{$users->postalcode}} </p>
                        </div>
                    </li>
                    <li>
                        <div class="li-left">
                            <p><b>Region :</b>  {{$users->region}} </p>

                        </div>
                        <div class="li-right">
                           <p><b>Tehsil :</b>  {{$users->tehsils}} </p>
                        </div>
                    </li>
                    <li>
                        <div class="li-left">
                            <p><b>GST No. :</b>  {{$users->gstcode}} </p>

                        </div>
                        <div class="li-right">
                           <p><b>PAN No. :</b>  {{$users->	pincode}} </p>
                        </div>
                    </li>
                </ul>
                {{-- <a href="#">Continue</a> --}}
            </div>
        </div>
    </main>
</div>