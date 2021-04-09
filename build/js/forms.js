/* 
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
	p.id = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    // Finally submit the form. 
    //form.submit();
}


function formhashJQ(form, password, password2) {
    // Create a new element input, this will be our hashed password field. 
	var p1 = document.createElement("input");
	var p2 = document.createElement("input");
    // Add the new element to our form. 
	
    form.appendChild(p1);
	p1.name = "p1";
    p1.type = "hidden";
    p1.value = hex_sha512(password.value);
	
	form.appendChild(p2);
	p2.name = "p2";
    p2.type = "hidden";
    p2.value = hex_sha512(password2.value);
	  
    // Make sure the plaintext password doesn't get sent. 
	password.value = "";
	password2.value = "";
}

function regformhash(form, uid, email, password, conf) {
    // Check each field has a value
    if (uid.value == '' || email.value == '' || password.value == '' || conf.value == '') {
        alert('Deve introduzir todos os campos. Tente novamente');
        return false;
    }
    
    // Check the username
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("O utilizador deve conter letras apenas, numeros e underscores. Tente novamente"); 
        form.username.focus();
        return false; 
    }
    
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords devem ter no mínimo 6 caracteres. Tente novamente');
        form.password.focus();
        return false;
    }
    
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords devem conter no mínimo 1 número, uma maiúscula e uma minúscula. Tente novamente');
        return false;
    }
    
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('As passwords não coincidem. Tente novamente');
        form.password.focus();
        return false;
    }
        
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";


    // Finally submit the form. 
    //form.submit();
    return true; 
	
	
}
