new Vue({
  el: "#app",
  data() {
    return {
      email: {
        value: "",
        required: true,
        isCorrect: false,
      },
      password: {
        value: "",
        required: true,
      },
      displayPassword: false,
    };
  },
  watch: {
    displayPassword() {
      if (this.displayPassword) $(".pwd").attr("type", "text");
      else $(".pwd").attr("type", "password");
    },
  },
  methods: {
    checkRequired(eve) {
      eve.required = !(eve.value == "");
      return eve.required;
    },
    isEmailValid() {
      this.email.isCorrect = !/([b][isc][tce][f][1][0-9][ma][05][0-9][0-9]@pucit.edu.pk)/gi.test(
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
    submitForm(e) {
      e.preventDefault();
      if (!this.checkRequired(this.email) && !this.checkRequired(this.password))
        return;
      if (!this.isEmailValid() || !this.isPasswordValid()) return;
      $(".loader").show();
      $.post(
        "php/lg.php",
        { email: this.email.value, password: this.password.value },
        (data, s) => {
          if (data == "Yes") window.location.href = "./main.php";
          else if (data == "Invalid") $(".error").show();
          else if (data == "No") alert("Error Occured! Try again later");
          else alert(data);
          $(".loader").hide();
        }
      );
    },
  },
});

new Vue({
  el: ".modal",
  data() {
    return {
      email: {
        value: "",
        isCorrect: true,
        isRequired: true,
      },
    };
  },
  methods: {
    isEmailValid() {
      this.email.isCorrect = !/([b][isc][tce][f][1][0-9][ma][05][0-9][0-9]@pucit.edu.pk)/gi.test(
        this.email.value
      );
      return this.email.isCorrect;
    },
    sendMail() {
      if (this.email.value == "") alert("Must Enter Email Address");
      else if (this.isEmailValid()) alert("Must Enter Valid Email Address");
      else {
        $(".loader").show();
        $.post(
          "php/rp.php",
          { email: this.email.value, request: "sendCode" },
          (data, s) => {
            console.log(data);
            if (data == "Code Sent")
              alert(
                "Your Reset Password link has been successfully sent to your registered mail"
              );
            else if (data == "Not Registered")
              alert("This Email Address Is Not Registered");
            else alert("An Error Occured! Try Again Later");
            $(".modal").removeClass("show");
            $(".modal-backdrop").remove();
            $(".loader").hide();
          }
        );
      }
    },
  },
});
