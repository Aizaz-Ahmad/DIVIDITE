let subjects = [
  'Analysis of Algorithms',
  'Artificial Intelligence',
  'Basic Electronics',
  'Calculus-1',
  'Calculus-2',
  'Capstone Project 1',
  'Capstone Project 2',
  'Communication Skills',
  'Compiler Construction',
  'Computer Architecture',
  'Computer Networks',
  'Computer Networks Lab',
  'Computer Oraganization And Assembly Language',
  'Computer Oraganization And Assembly Language Lab',
  'DBA',
  'Data Structure And Algorithms',
  'Data Structure And Algorithms Lab',
  'Database System',
  'Database Systems Lab',
  'Digital Logic Design',
  'Digital Logic Design Lab',
  'Discrete Mathematics',
  'EAD',
  'Electricity And Magnetism',
  'Foreign Language/ Arabic Language',
  'Foreign Language/German/Chinese',
  'HCI',
  'Humanities',
  'Intro To Psychology',
  'Intro To Sociology',
  'Introduction To Computing',
  'Introduction To Economics',
  'Islamic And Pakistan Studies',
  'Linear Algebra',
  'MC',
  'MIS/FA',
  'Mobile Computing',
  'Object Oriented Analysis And Design',
  'Object Oriented Programming',
  'Object Oriented Programming Lab',
  'Operating System',
  'Probabilty And Statistics',
  'Professional Of Ethics',
  'Programming Fundamentals',
  'Programming Fundamentals Lab',
  'Social Science Effective/Entrepreneurship',
  'Social Science Effective/Principles of Management',
  'Social Science Effective/Project Management',
  'Software Engineering',
  'Software Project Management',
  'Software Quality Assurance',
  'Software Requirement Engineering',
  'System Programming',
  'Technical And Business Writing',
  'Theory of Automata',
  'Web Engineering',
  'Web Engineering Lab',
  'Writing Workshop',
];
let postComponent = Vue.component('post', {
  template: '#post',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  methods: {
    getExtension() {
      let fileName = this.data.fileName;
      fileName = fileName.split('').reverse().join('');
      let ext = fileName
        .substring(0, fileName.indexOf('.'))
        .split('')
        .reverse()
        .join('');
      return ext;
    },
    downloadFile() {
      window.location.href = `php/downloadFile.php?fileName=${this.data.fileName}`;
      $.post(
        'php/updateDownload.php',
        { fileName: this.data.fileName },
        (data, s) => {
          if (data == 'Yes') this.data.downloads++;
        }
      );
    },
  },
});
let postsVue = new Vue({
  el: '#app',
  mounted() {
    $.post(
      'php/postCreater.php',
      (data, s) => {
        this.posts = data;
        $('.loader').hide();
      },
      (dataType = 'json')
    );
  },
  data() {
    return {
      subjects: subjects,
      subjectFilter: '',
      category: '',
      checked: [],
      searchText: '',
      posts: [],
      sortBy: '',
      dateUploaded: '',
      postsShown: 12,
    };
  },
  methods: {
    increasePostsShown(event) {
      event.preventDefault();
      this.postsShown += 12;
    },
    decreasePostsShown(event) {
      event.preventDefault();
      this.postsShown -= 12;
    },
  },
  computed: {
    searchedPosts() {
      if (this.posts.length == 0) return;
      let text = this.searchText.toLowerCase();
      let filtered = this.posts.filter(
        post =>
          post.fileName.toLowerCase().indexOf(text) > -1 ||
          post.uploaderEmail.toLowerCase().indexOf(text) > -1
      );
      filtered =
        this.category != ''
          ? filtered.filter(post => post.category == this.category)
          : filtered;
      filtered =
        this.sortBy != ''
          ? filtered.sort((a, b) => b.downloads - a.downloads)
          : filtered;
      filtered =
        this.dateUploaded != ''
          ? filtered.filter(
              e => e.dateUploaded.substring(0, 10) == this.dateUploaded
            )
          : filtered;
      return this.subjectFilter != ''
        ? filtered.filter(post => post.subject == this.subjectFilter)
        : filtered;
    },
  },
  watch: {
    checked() {
      if (!this.checked.find(e => e == 'subject')) this.subjectFilter = '';
      if (!this.checked.find(e => e == 'category')) this.category = '';
      if (!this.checked.find(e => e == 'sort')) this.sortBy = '';
      if (!this.checked.find(e => e == 'date')) this.dateUploaded = '';
    },
  },
});

let date = new Date();
let month = String(date.getMonth() + 1);
let day = String(date.getDate());
let todayString = `${date.getFullYear()}-${month.padStart(
  2,
  '0'
)}-${day.padStart(2, '0')}`;
$('#date').attr('max', todayString);
