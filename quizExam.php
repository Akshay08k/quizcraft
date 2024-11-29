<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMaster - MCQ Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.5/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100" x-data="quizApp()">
    <div id="quiz-container" class="container mx-auto p-4 h-screen flex flex-col justify-between">
        <header class="text-center mb-8">
            <h1 class="text-4xl font-bold text-blue-600">QuizMaster</h1>
            <p class="text-xl text-gray-600" x-text="quizTitle"></p>
        </header>

        <main class="flex-grow">
            <div x-show="!quizStarted" class="text-center">
                <button @click="startQuiz"
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg text-xl hover:bg-blue-600 transition">Start
                    Quiz</button>
            </div>

            <div x-show="quizStarted" class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold"
                        x-text="`Question ${currentQuestionIndex + 1} of ${questions.length}`"></h2>
                    <div class="text-xl font-bold" x-text="formatTime(timeLeft)"></div>
                </div>
                <p class="text-lg mb-4" x-text="currentQuestion.question"></p>
                <div class="space-y-2">
                    <template x-for="(option, index) in currentQuestion.options" :key="index">
                        <button @click="selectAnswer(index)" class="w-full text-left p-3 rounded"
                            :class="{'bg-blue-100 hover:bg-blue-200': selectedAnswer !== index, 'bg-blue-500 text-white': selectedAnswer === index}"
                            x-text="option">
                        </button>
                    </template>
                </div>
            </div>
        </main>

        <footer class="mt-8 text-center text-gray-500">
            <p>&copy; 2024 QuizMaster. All rights reserved.</p>
        </footer>
    </div>

    <script>
        function quizApp() {
            return {
                quizTitle: "General Knowledge Quiz",
                quizStarted: false,
                questions: [
                    {
                        question: "What is the capital of France?",
                        options: ["London", "Berlin", "Paris", "Madrid"],
                        correctAnswer: 2
                    },
                    {
                        question: "Which planet is known as the Red Planet?",
                        options: ["Mars", "Jupiter", "Venus", "Saturn"],
                        correctAnswer: 0
                    },
                    {
                        question: "Who painted the Mona Lisa?",
                        options: ["Vincent van Gogh", "Leonardo da Vinci", "Pablo Picasso", "Michelangelo"],
                        correctAnswer: 1
                    }
                    // Add more questions as needed
                ],
                currentQuestionIndex: 0,
                selectedAnswer: null,
                timeLeft: 10, // 1:30 minutes in seconds
                timer: null,

                get currentQuestion() {
                    return this.questions[this.currentQuestionIndex];
                },

                startQuiz() {
                    this.quizStarted = true;
                    this.goFullscreen();
                    this.startTimer();
                },

                goFullscreen() {
                    const elem = document.documentElement;
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.mozRequestFullScreen) { // Firefox
                        elem.mozRequestFullScreen();
                    } else if (elem.webkitRequestFullscreen) { // Chrome, Safari and Opera
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) { // IE/Edge
                        elem.msRequestFullscreen();
                    }
                },

                startTimer() {
                    this.timeLeft = 10;
                    this.timer = setInterval(() => {
                        this.timeLeft--;
                        if (this.timeLeft <= 0) {
                            this.nextQuestion();
                        }
                    }, 1000);
                },

                formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = seconds % 60;
                    return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
                },

                selectAnswer(index) {
                    this.selectedAnswer = index;
                },

                nextQuestion() {
                    clearInterval(this.timer);
                    if (this.currentQuestionIndex < this.questions.length - 1) {
                        this.currentQuestionIndex++;
                        this.selectedAnswer = null;
                        this.startTimer();
                    } else {
                        this.endQuiz();
                    }
                },

                endQuiz() {
                    alert("Quiz completed! Implement your end-of-quiz logic here.");
                    document.exitFullscreen();
                }
            }
            alert("Quiz Started")
        }
        quizApp(10)
    </script>
</body>

</html>