/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      maxWidth: {
        "4/5": "80%",
      },
      maxHeight: {
        "4/5": "80%",
      },
      animation: {
        alert: "alert 0.5s ease-in-out",
        modalOpen: "modalOpen 0.2s ease-in-out",
        wrongValue: "wrongValue 0.2s linear",
        search: "search 0.5s ease-in-out",
        newElement:
          "newElement 0.5s cubic-bezier(0.7, 0, 0.84, 0) 0s 1 normal none;",
        shakeAndGrow: "shakeAndGrow 0.5s linear",
        combo: "combo 1s ease-in-out",
        showGame: "showGame 1s ease-in",
        shake2: "shake2 0.5s linear infinite",
      },
      keyframes: {
        showGame: {
          "0%": {
            transform: "translateY(0) scale(1)",
          },
          "10%": {
            transform: "translateY(-10px) scale(1)",
          },
          "20%": {
            transform: "translateY(-10px) scale(1)",
          },
          "30%": {
            transform: "translateY(0px) scale(1)",
          },
          "40%": {
            transform: "translateY(-25px) scale(2)",
          },
          "50%": {
            transform: "translateY(-40px) scale(3)",
          },
          "60%": {
            transform: "translateY(-100px) scale(5)",
          },
          "70%": {
            transform: "translateY(-150px) scale(10)",
          },
          "80%": {
            transform: "translateY(-200px) scale(20)",
          },
          "90%": {
            transform: "translateY(-260px) scale(40)",
          },
          "100%": {
            transform: "translateY(-250px) scale(80)",
          },
        },
        shake2: {
          "0%": {
            transform: "rotate(0deg) scale(1.2)", // 왼쪽
          },
          "25%": {
            transform: "rotate(-5deg) scale(1.2)", // 중앙
          },
          "50%": {
            transform: "rotate(0deg) scale(1.2)", // 오른쪽
          },
          "75%": {
            transform: "rotate(5deg) scale(1.2)", // 오른쪽
          },
          "100%": {
            transform: "rotate(0deg) scale(1.2)", // 오른쪽
          },
        },
        combo: {
          "0%": { opacity: "0", transform: "scale(0.5)" },
          "50%": { opacity: "1" },
          "100%": { opacity: "0", transform: "scale(1.5)" },
        },
        alert: {
          "0%": { transform: "translateY(-100%)" },
          "100%": { transform: "translateY(0)" },
        },
        modalOpen: {
          from: {
            opacity: "0",
            transform: "scale(0.8)",
          },
          to: {
            opacity: "1",
            transform: "scale(1)",
          },
        },
        fadeIn: {
          "0%": {
            opacity: "0",
          },
          "100%": {
            opacity: "1",
          },
        },
        wrongValue: {
          "0%": {
            transform: "translateX(0)",
          },
          "25%": {
            transform: "translateX(-5px)",
          },
          "50%": {
            transform: "translateX(5px)",
          },
          "75%": {
            transform: "translateX(-5px)",
          },
          "100%": {
            transform: "translateX(0)",
          },
        },
        search: {
          "0%": {
            transform: "scale(1)",
          },
          "25%": {
            transform: "scale(1.5)",
          },
          "40%": {
            transform: "scale(1.5) rotate(-5deg)",
          },
          "50%": {
            transform: "scale(1.5) rotate(10deg)",
          },
          "60%": {
            transform: "scale(1.5) rotate(-5deg)",
          },
          "75%": {
            transform: "scale(1.5)",
          },
          "100%": {
            transform: "scale(1)",
          },
        },
        newElement: {
          "0%": {
            transform: "scale(0.8)",
            opacity: "0",
          },
          "100%": {
            transform: "scale(1)",
            opacity: "1",
          },
        },
        shakeAndGrow: {
          "0%": {
            transform: "scale(1) rotate(0deg)",
          },
          "10%, 30%, 50%, 70%, 90%": {
            transform: "scale(1.1) rotate(5deg)",
          },
          "20%, 40%, 60%, 80%": {
            transform: "scale(1.1) rotate(-5deg)",
          },
          "90%": {
            transform: "scale(0.4) rotate(0deg)",
          },
          "100%": {
            transform: "scale(1)",
          },
        },
      },

      backgroundImage: {
        "gradient-radial": "radial-gradient(var(--tw-gradient-stops))",
        "gradient-conic":
          "conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))",
      },
    },
  },
  plugins: [],
};
