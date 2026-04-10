<div>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Vande Mileager</title>

    <meta name="description" content="" />
    <style>
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    
}

body{
    font-size: 1em;
    background-image: url('image/loginbackground.jpg');
    background-size: cover;
}

.login_form{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.form{
    width: 23em;
    padding:2em;
    border-radius: 1em;
    box-shadow: 0 10px 25px rgba(90,100,100,.2);
}

.form_title{
    font-weight: 300;
    margin-bottom: 1.3em;
    text-align: center;
}

.form_div{
    position: relative;
    height: 3em;
    margin-bottom: 1.6em;
}


.form_input{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    font-size: 1em;
    border: .1em solid #dadce0;
    border-radius: .5em;
    outline: none;
    padding: 1em;
    z-index: 1;
    background: none;
}

.form_label{
    position: absolute;
    left: 1em;
    top: 1em;
    padding: 0 .25em;
    background-color: #fff;
    color: #80868b;
    font-size: 1em;
    transition: .4s;
}

.form_button{
    width: 100%;
    display: block;
    margin-left: auto;
    padding: 1em 2em;;
    outline: none;
    border: none;
    background-color: rgb(76,139,253);
    color: #fff;
    font-size: 1em;
    border-radius: .5em;
    cursor: pointer;
    transition: .4s;
}

.form_button:hover{
    transform: scale(0.90);
    box-shadow: 0 5px 5px rgba(0,0,0,0.20);
}

.form_input:focus + .form_label{
    top: -.5em;
    left: .8em;
    color: rgb(28,164,248);
    font-size: .80em;
    font-weight: 600;
    z-index: 5;
}

.form_input:not(:placeholder-shown).form_input:not(:focus) + .form_label{
    top: -.5em;
    left: .8em;
    font-size: .80em;
    font-weight: 600;
    z-index: 5;
}

.form_input:focus{
    border: .1em solid rgb(28,164,248);
}
@media (max-width:576px){
    .from{
        width: 75%;
        height: 40%;
        background: white;
    }
}
</style>
</head>
<body>
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="login_form">
                <form action="{{ route('login') }}" class="form" method="post">
                    @csrf
                    <center><img src="{{asset('image/vmlogo.png')}}" width="100"/></center>
                    <h1 class="form_title mt-3"> Log In </h1>
        
                    
                    <div class="form_div mt-5">
                        <input type="email" class="form_input" placeholder=" " name="email">
                        <label class="form_label" value="{{ __('Email') }}">Email</label>
                    </div>
        
                    <div class="form_div">
                        <input type="password" class="form_input" placeholder=" " name="password">
                        <label class="form_label" value="{{ __('Password') }}">Password</label>
                    </div>

            
                    <input type="submit" class="form_button" value="Log In">
                    <!--<a href="{{ __('register') }}">Please Register Yourself</a>-->
                </form>
               
            </div>
        </div>
    </div>
  </div>
</body>
</html>
</div>
