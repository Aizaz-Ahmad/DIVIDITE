let Lsubjects = [
  "Analysis of Algorithms",
  "Artificial Intelligence",
  "Basic Electronics",
  "Calculus-1",
  "Calculus-2",
  "Capstone Project 1",
  "Capstone Project 2",
  "Communication Skills",
  "Compile Construction",
  "Computer Architecture",
  "Computer Networks",
  "Computer Networks Lab",
  "Computer Oraganization And Assembly Language",
  "Computer Oraganization And Assembly Language Lab",
  "DBA",
  "Data Structure And Algorithms",
  "Data Structure And Algorithms Lab",
  "Database System",
  "Database Systems Lab",
  "Digital Logic Design",
  "Digital Logic Design Lab",
  "Discrete Mathematics",
  "EAD",
  "Electricity And Magnetism",
  "Foreign Language/ Arabic Language",
  "Foreign Language/German/Chinese",
  "HCI",
  "Humanities",
  "Intro To Psychology",
  "Intro To Sociology",
  "Introduction To Computing",
  "Introduction To Economics",
  "Islamic And Pakistan Studies",
  "Linear Algebra",
  "MC",
  "MIS/FA",
  "Mobile Computing",
  "Object Oriented Analysis And Design",
  "Object Oriented Programming",
  "Object Oriented Programming Lab",
  "Operating System",
  "Probabilty And Statistics",
  "Professional Of Ethics",
  "Programming Fundamentals",
  "Programming Fundamentals Lab",
  "Social Science Effective/Entrepreneurship",
  "Social Science Effective/Principles of Management",
  "Social Science Effective/Project Management",
  "Software Engineering",
  "Software Project Management",
  "Software Quality Assurance",
  "Software Requirement Engineering",
  "System Programming",
  "Technical And Business Writing",
  "Theory of Automata",
  "Web Engineering",
  "Web Engineering Lab",
  "Writing Workshop",
];
let types = ["Book", "Slides", "Hand Written Notes", "Excel Sheets"];
let extensions = ["pdf", "docx", "doc", "xlsx", "xls", "pptx", "ppt", "ppsx"];

class Post {
  constructor(subject, type, date, user, fileName, extension) {
    this.subject = subject;
    this.type = type;
    this.date = date;
    this.user = user;
    this.fileName = fileName;
    this.downloads = 0;
  }
}
const createFileName = (extension) => {
  let str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  let string = "";
  for (let i = 0; i < Math.round(Math.random() * 20 + 10); i++)
    string = string + str[Math.round(Math.random() * 51)];
  return `${string}.${extension}`;
};
const createRandomPost = () => {
  let subject = Lsubjects[Math.round(Math.random() * (Lsubjects.length - 1))];
  let type = types[Math.round(Math.random() * (types.length - 1))];
  let extension =
    extensions[Math.round(Math.random() * (extensions.length - 1))];
  let user = `bsef18m5${Math.round(Math.random() * 90)}@pucit.edu.pk`;
  let fileName = createFileName(extension);
  return new Post(subject, type, "31-04-2018", user, fileName, extension);
};
let recent = [];
let mostDownloaded = [];
let all = [];
for (let i = 0; i < 4; i++) {
  recent.push(createRandomPost());
  mostDownloaded.push(createRandomPost());
}
for (let i = 0; i < 44; i++) all.push(createRandomPost());
let posts = {
  recent: recent,
  mostDownloaded: mostDownloaded,
  all: all,
};
