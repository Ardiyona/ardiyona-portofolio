// Hardcoded profile — sourced from CV. Edit here to update.
// ponytail: single source for static profile; dynamic content (projects/experience) comes from the API.

export const profile = {
  name: "Dhiya Rakha Ardiyona",
  role: "Full Stack Developer",
  // Drop your 3x4 portrait at frontend/public/profile.jpg (or change this path).
  // Falls back to an initials monogram if the file is missing.
  photo: "/profile.jpg",
  tagline: "Membangun aplikasi web yang efisien, stabil, dan scalable.",
  bio: [
    "Full Stack Developer yang membangun aplikasi web dari tampilan sampai sistem di baliknya. Saya banyak mengerjakan produk yang benar-benar dipakai — dari aplikasi tagihan ISP dan pembayaran online hingga sistem pengelolaan anggaran.",
    "Terbiasa membuat fitur baru sekaligus merapikan sistem yang sudah berjalan — dari REST API dan integrasi payment gateway sampai otomasi yang mengurangi pekerjaan manual. Saya suka menyelesaikan masalah dengan solusi yang sederhana dan tepat.",
  ],

  contacts: {
    email: "rakhaardiyona98@gmail.com",
    phone: "085854983795",
    github: "https://github.com/Ardiyona",
    linkedin: "https://www.linkedin.com/in/dhiya-rakha-ardiyona/",
  },

  education: {
    school: "Politeknik Negeri Malang",
    program: "D-IV Sistem Informasi Bisnis",
    gpa: "3.53 / 4.00",
    period: "Aug 2022 – 2026",
  },

  skills: [
    "PHP", "Laravel", "JavaScript", "React", "Tailwind", "Flutter",
    "MySQL", "PostgreSQL", "Java", "C#", "HTML", "CSS", "Git",
  ],
} as const;
