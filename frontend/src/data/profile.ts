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
    "Full Stack Developer yang senang membangun aplikasi web dari awal sampai jadi — mulai dari sisi tampilan yang dipakai pengguna hingga sistem di baliknya. Saya fokus membuat produk yang cepat, stabil, dan nyaman digunakan.",
    "Selama ini saya terlibat mengembangkan aplikasi nyata yang dipakai untuk mengelola pelanggan, penagihan, dan pembayaran, serta ikut merapikan dan menambah fitur pada sistem yang sudah berjalan. Selain web, saya juga pernah menggarap aplikasi mobile.",
    "Saya terbiasa bekerja dalam tim, senang belajar hal baru, dan berusaha menyelesaikan masalah dengan cara yang sederhana namun tepat.",
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
