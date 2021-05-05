$('#app').css('display', 'block');
//AOS.init();
new Vue({
  el: '#app',
  data() {
    return {
      email: {
        value: '',
        required: true,
        isCorrect: false,
        isAlreadyPresent: false,
      },
      password: {
        value: '',
        required: true,
        isLengthCorrect: false,
        hideProgress: true,
        containsSpace: false,
        hasInvalidChar: false,
      },
      confirmPassword: {
        value: '',
        required: true,
        isSameAsPassword: true,
      },
      progressbar: {
        type: '',
        colorClass: '',
        width: '',
      },
      displayPassword: false,
    };
  },
  watch: {
    displayPassword() {
      if (this.displayPassword) $('.pwd').attr('type', 'text');
      else $('.pwd').attr('type', 'password');
    },
  },
  methods: {
    checkRequired(eve) {
      eve.required = !(eve.value == '');
      return eve.required;
    },
    containsPassed(str) {
      for (let i = 0; i < str.length; i++)
        if (this.password.value.indexOf(str[i]) > -1) return true;
      return false;
    },
    containsAlpha() {
      let str = /[a-zA-Z]/g;
      return str.test(this.password.value);
    },
    containsNumeric() {
      return /[0-9]/g.test(this.password.value);
    },
    containSpace() {
      return /[ ]/g.test(this.password.value);
    },
    containsInvalidChar() {
      return (
        !this.containSpecialCharacters() &&
        !this.containsAlpha() &&
        !this.containsNumeric()
      );
    },
    containSpecialCharacters() {
      return /[~`!@#$%^_&*]/g.test(this.password.value);
    },
    isPasswordStrong() {
      return (
        this.containsAlpha() &&
        this.containsNumeric() &&
        this.containSpecialCharacters()
      );
    },
    isPasswordNormal() {
      return (
        (this.containsAlpha() && this.containsNumeric()) ||
        (this.containsNumeric() && this.containSpecialCharacters()) ||
        (this.containsAlpha() && this.containSpecialCharacters())
      );
    },
    checkPassword() {
      this.isconfirmPassword();
      this.password.hideProgress = this.password.isLengthCorrect = !(
        this.password.value.length >= 8
      );
      this.password.hideProgress = this.password.containsSpace = this.containSpace();
      if (this.password.isLengthCorrect || this.password.containsSpace) return;
      const types = ['WEAK', 'NORMAL', 'STRONG'];
      const widths = ['50%', '75%', '100%'];
      const bgColors = ['bg-danger', 'bg-warning', 'bg-success'];
      let index = this.isPasswordStrong() ? 2 : this.isPasswordNormal() ? 1 : 0;
      this.progressbar.type = types[index];
      this.progressbar.colorClass = bgColors[index];
      this.progressbar.width = widths[index];
    },
    isconfirmPassword() {
      this.confirmPassword.isSameAsPassword =
        this.password.value == this.confirmPassword.value;
    },
    isEmailValid() {
      this.email.isCorrect =
        this.email.value.length != 23 ||
        !/([b][isc][tce][f][1][0-9][ma][05][0-9][0-9]@pucit.edu.pk)/gi.test(
          this.email.value
        );
      return !this.email.isCorrect && this.email.required;
    },
    isPasswordValid() {
      return (
        this.password.required &&
        !this.password.isLengthCorrect &&
        !this.password.containSpace
      );
    },
    isConfPasswordValid() {
      return (
        this.confirmPassword.required && this.confirmPassword.isSameAsPassword
      );
    },
    setAlreadyPresent() {
      this.email.isAlreadyPresent = true;
    },
    submitForm(e) {
      e.preventDefault();
      if (
        !this.checkRequired(this.email) &&
        !this.checkRequired(this.password) &&
        !this.checkRequired(this.confirmPassword)
      )
        return;
      if (
        !this.isEmailValid() ||
        !this.isPasswordValid() ||
        !this.isConfPasswordValid()
      )
        return;
      $('.loader').show();
      $.post('php/emailCheck.php', { email: this.email.value }, (data, s) => {
        if (data == 'No') {
          alert(
            'Account with this Email Address Already Exists! Try Logging In'
          );
          $('.loader').hide();
        } else if (data == 'Invalid') this.email.isCorrect = true;
      });
      $('.loader').show();
      $.post(
        'php/su.php',
        { email: this.email.value, password: this.password.value },
        (data, s) => {
          if (data == 'Yes') window.location.href = './validate.php';
          else if (data == 'No') alert('An Error Occured! Try Again');
          else alert(data);
          $('.loader').hide();
        }
      );
    },
  },
});
