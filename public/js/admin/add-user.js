document.getElementById('user-type').addEventListener('change', function () {
    const userType = this.value;
    const signupPage = document.querySelector('.signup-page');
    const codeInput = document.getElementById('code');
    const firstnameInput = document.getElementById('firstname');
    const lastnameInput = document.getElementById('lastname');
    const emailInput = document.getElementById('email');
    const filiereInput = document.getElementById('filiere-input');
    const hiddenUserType = document.getElementById('hidden-user-type');
    var first =document.getElementById('first-ipt');
    var second =document.getElementById('second-ipt');
    var third =document.getElementById('third-ipt');
    var pass =document.getElementById('password');
    var confirm =document.getElementById('password_confirmation');
    var title =document.getElementById('tit');

    hiddenUserType.value = userType;

    // Reset form fields
    document.getElementById('forma').reset();

    // Hide all fields by default
    firstnameInput.style.display = 'none';
    lastnameInput.style.display = 'none';
    emailInput.style.display = 'none';
    filiereInput.style.display = 'none';
    document.getElementById('password').style.display = 'block';
    document.getElementById('password_confirmation').style.display = 'block';

    // Show relevant fields based on user type
    if (userType == '1') {
        // Admin: Show only code and password fields
        add1.style.display = 'none';
        title.innerText = 'Add Admin';
        first.style.justifyContent = 'center';
        pass.style.display = 'block';
        pass.style.marginTop = '0';
        confirm.style.display = 'block';
        third.style.display = 'block';
        signupPage.style.display = 'block';
        codeInput.placeholder = 'Admin Code';
    } else if (userType == '2') {
        // Teacher: Show all fields except filiere
        add1.style.display = 'none';
        title.innerText = 'Add Teacher';
        signupPage.style.display = 'block';
        codeInput.placeholder = 'Teacher Code';
        firstnameInput.style.display = 'block';
        lastnameInput.style.display = 'block';
        emailInput.style.display = 'block';
    } else if (userType == '3') {
        // Student: Show all fields including filiere
        add1.style.display = 'none';
        title.innerText = 'Add Student';
        signupPage.style.display = 'block';
        codeInput.placeholder = 'Student Code';
        firstnameInput.style.display = 'block';
        lastnameInput.style.display = 'block';
        emailInput.style.display = 'block';
        filiereInput.style.display = 'block';
    } else {
        // Hide signup page if no valid user type is selected
        signupPage.style.display = 'none';
    }
});

document.title = 'Add User';
