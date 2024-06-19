import { login, check, logout } from "./utils/admin/login.js";
import { Swal } from './utils/swal.js'
import {buildAdminElements} from './utils/admin/buildAdminElements.js'

/**
 * Admin Login
 */
document.querySelector('.admin-login').addEventListener('click', function () {
    loginSwal()
});

function loginSwal() {
    Swal.fire({
        title: 'Login',
        html: `
            <input type="text" onkeyup="keyDownConfirm(event)" id="username" class="swal2-input" placeholder="Username">
            <input type="password" onkeyup="keyDownConfirm(event)" id="password" class="swal2-input" placeholder="Password">
        `,
        showCancelButton: true,
        confirmButtonText: 'Login',
        preConfirm: () => {
            const username = Swal.getPopup().querySelector('#username').value;
            const password = Swal.getPopup().querySelector('#password').value;
            if (!username || !password) {
                Swal.showValidationMessage('Please enter both username and password');
                return false;
            }
            return { username: username, password: password };
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            let loginAttempt = await login(result.value.username, result.value.password)
            if (!loginAttempt.success) {
                Swal.fire({
                    title: 'Login Error!',
                    text: loginAttempt.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    result ? loginSwal() : ""
                });
            } else {
                buildAdminElements()
                Swal.fire({
                    title: 'Login Success!',
                    text: loginAttempt.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
            }
        }
    });
}

export function logoutSwal(){
    Swal.fire({
        title: 'Are you sure?',
        text: "You will logout ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, log out!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            logout()
        }
    });
}

export function keyDownConfirm(e){
    if (e.key === 'Enter') {
        e.preventDefault(); // Prevent default Enter key behavior
        Swal.clickConfirm(); // Programmatically click the confirm button
    }
}

export async function checkAdminStatus(){
    let isAdminLoggedIn = await check()
    if(isAdminLoggedIn.success){
        buildAdminElements()
    }else{
        document.querySelector(".admin-login").style.display = "block"
    }
}