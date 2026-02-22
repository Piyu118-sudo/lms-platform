import { Head, router } from "@inertiajs/react"
import { Button } from "@/components/ui/button"

interface Lesson {
    id: number
    title: string
    content: string
    video_url: string | null
}

interface Course {
    id: number
    title: string
    lessons: Lesson[]
}

interface Props {
    course: Course
    currentLesson: Lesson
    completedLessonIds: number[]
}

export default function CoursePlayer({
                                         course,
                                         currentLesson,
                                         completedLessonIds
                                     }: Props) {

    const selectLesson = (lessonId: number) => {
        router.get(route("student.lessons.show", lessonId))
    }

    const goToNextLesson = () => {
        const currentIndex = course.lessons.findIndex(
            (lesson) => lesson.id === currentLesson.id
        )

        if (currentIndex < course.lessons.length - 1) {
            const nextLesson = course.lessons[currentIndex + 1]
            router.get(route("student.lessons.show", nextLesson.id))
        }
    }

    // ✅ Correct Progress Calculation
    const progressPercentage =
        course.lessons.length > 0
            ? Math.round(
                (completedLessonIds.length / course.lessons.length) * 100
            )
            : 0

    const isCompleted =
        completedLessonIds.includes(currentLesson.id)

    return (
        <>
            <Head title={course.title} />

            <div className="flex min-h-screen bg-gray-50">

                {/* Sidebar */}
                <div className="w-1/4 border-r bg-white p-4 overflow-y-auto">
                    <h2 className="font-bold mb-4">
                        {course.title}
                    </h2>

                    <div className="space-y-2">
                        {course.lessons.map((lesson) => {
                            const isActive =
                                lesson.id === currentLesson.id

                            const isLessonCompleted =
                                completedLessonIds.includes(lesson.id)

                            return (
                                <div
                                    key={lesson.id}
                                    onClick={() => selectLesson(lesson.id)}
                                    className={`p-2 rounded cursor-pointer flex justify-between items-center ${
                                        isActive
                                            ? "bg-blue-100 font-semibold"
                                            : "hover:bg-gray-100"
                                    }`}
                                >
                                    <span>{lesson.title}</span>

                                    {isLessonCompleted && (
                                        <span className="text-green-600 text-sm">
                                            ✔
                                        </span>
                                    )}
                                </div>
                            )
                        })}
                    </div>
                </div>

                {/* Main Content */}
                <div className="w-3/4 p-6">

                    {/* Progress Bar */}
                    <div className="mb-6">
                        <div className="flex justify-between text-sm mb-1">
                            <span>Progress</span>
                            <span>{progressPercentage}%</span>
                        </div>
                        <div className="w-full bg-gray-200 rounded h-2">
                            <div
                                className="bg-blue-600 h-2 rounded"
                                style={{ width: `${progressPercentage}%` }}
                            />
                        </div>

                        {progressPercentage === 100 && (
                            <div className="mt-4 p-3 bg-green-100 text-green-700 rounded">
                                🎉 Congratulations! You completed this course.
                            </div>
                        )}
                    </div>

                    <h1 className="text-2xl font-bold mb-4">
                        {currentLesson.title}
                    </h1>

                    {currentLesson.video_url && (
                        <iframe
                            src={currentLesson.video_url}
                            className="w-full h-96 mb-6 rounded"
                            allowFullScreen
                        />
                    )}

                    <div
                        className="prose mb-6"
                        dangerouslySetInnerHTML={{
                            __html: currentLesson.content ?? ""
                        }}
                    />

                    <Button
                        disabled={isCompleted}
                        onClick={() =>
                            router.post(
                                route(
                                    "student.lessons.complete",
                                    currentLesson.id
                                ),
                                {},
                                {
                                    onSuccess: () => {
                                        goToNextLesson()
                                    }
                                }
                            )
                        }
                    >
                        {isCompleted
                            ? "Completed ✔"
                            : "Mark as Complete"}
                    </Button>
                </div>
            </div>
        </>
    )
}
