<?php header("Content-type: text/css"); ?>

@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap');

@font-face {
    font-family: Poppins-Regular;
    src: url('../fonts/poppins/Poppins-Regular.ttf');
}

@font-face {
    font-family: Poppins-Medium;
    src: url('../fonts/poppins/Poppins-Medium.ttf');
}

@font-face {
    font-family: Poppins-Bold;
    src: url('../fonts/poppins/Poppins-Bold.ttf');
}

@font-face {
    font-family: Poppins-SemiBold;
    src: url('../fonts/poppins/Poppins-SemiBold.ttf');
}

html {
	background: #F2F2F2;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}

body {
	margin: 0px;
	height: 100vh;
}

#navbar {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}

li, a, button {
	font-family: 'Montserrat', sans-serif;
	font-weight: 600;
	font-size: 20px;
	color: black;
	text-decoration: none;
}

header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 5px 5%;
	box-shadow: 0 6px 6px -6px black;
    background-color: #FFF;
}

.logo {
	cursor: pointer;
	width: auto;
	height: 2vw;
	
}

.nav-links {
	list-style: none;
}

.nav-links li {
	display: inline-block;
	padding: 0 20px;
}

.nav-links a {
	transition: all 0.3s ease 0s;
}

.nav-links a:hover {
	color: #6927FF;
}

.btn-ln {
	display: flex;
	gap: 1vw;
}

.login-btn {
	background-color: #000;
}

.signup-btn {
	background-color: #6927FF;
}

.btn {
	padding: 9px 25px;
	color: #FFF;
	border: none;
	border-radius: 20px;
	cursor: pointer;
	transition: all 0.3s ease 0s;
}

.btn:hover {
	background-color: rgba(0, 0, 0, 0.5);
}

#search-page {
	display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
	font-size: 120% ;
    font-family: 'Open Sans', sans-serif;
	height: 90vh;
}

h1.temp{
    margin:0;
    margin-bottom: 0.4em;
}
.description {
    text-transform: capitalize;
    margin-left: 5px;
}
.flex{
    display: flex;
    align-items: center;
}

.card {
    background: #000000d0;
    color:white;
    padding: 2em;
    border-radius: 30px;
    width: 100%;
    max-width: 420px;
    margin:1em;
}

.search{
    display:flex;
    align-items:center;
    justify-content:center;
}

.search-btn {
    margin: 0;
    border: 1px solid rgba(0, 0, 0, 0.2);
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    height: 56px;
    width: 70px;
    outline: none;
    background: #000;
    border-radius: 0px 20px 20px 0px;
    color: white;
    cursor: pointer;
    transition: 0.2s ease-in-out;
}

input.search-bar {
    border: 1px solid rgba(0, 0, 0, 0.2);
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 20px 0 0 20px;
    outline: none;
    padding: 0.5em 1em;
    background: #FFF;
    color: black    ;
    font-family: inherit;
    font-size: 120%;
    width:calc(100% - 100px);
}

.search-btn:hover {
    background: #4b1db5;
}

.new-search{
    display:flex;
    align-items:center;
    justify-content:center;
}

.new-search-btn {
    margin: 0.5em;
    border-radius: 50%;
    border: none;
    height: 46px;
    width: 46px;
    outline: none;
    background: #7c7c7c2b;
    color: white;
    cursor: pointer;
    transition: 0.2s ease-in-out;
}

input.new-search-bar {
    border: none;
    outline: none;
    padding: 0.5em 1em;
    border-radius: 24px;
    background: #7c7c7c2b;
    color: white;
    font-family: inherit;
    font-size: 120%;
    width:calc(100% - 100px);
}

.new-search-btn:hover {
    background: #7c7c7c6b;
}

.weather.loading {
    visibility: hidden;
    max-height: 20px;
    position: relative;
  }
  
  .weather.loading:after {
    visibility: visible;
    content: "Loading...";
    color: white;
    position: absolute;
    top: 0;
    left: 20px;
  }

  