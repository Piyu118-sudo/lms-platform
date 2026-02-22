import { Head, router } from "@inertiajs/react"
import route from "ziggy-js"
import { Button } from "@/components/ui/button"

interface Course {
    id: number
    title: string
    thumbnail: string | null
    progress: number
}

interface Props {
    courses: Course[]
}

export default function Dashboard({ courses }: Props) {
    return (
        <>
            <Head title="Dashboard" />

            <div className="max-w-6xl mx-auto p-6">
                <h1 className="text-2xl font-bold mb-6">
                    My Courses
                </h1>

                {courses.length === 0 && (
                    <div className="bg-gray-50 border rounded-lg p-6 text-center">
                        <p className="text-muted-foreground">
                            You are not enrolled in any courses.
                        </p>
                    </div>
                )}

                <div className="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                    {courses.map((course) => (
                        <div
                            key={course.id}
                            className="border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition"
                        >
                            <img
                                src={
                                    course.thumbnail
                                        ? course.thumbnail
                                        : "/placeholder.jpg"
                                }
                                alt={course.title}
                                className="w-full h-40 object-cover"
                            />

                            <div className="p-4 space-y-3">
                                <h2 className="font-semibold text-lg">
                                    {course.title}
                                </h2>

                                {/* Progress Bar */}
                                <div>
                                    <div className="flex justify-between text-sm mb-1">
                                        <span>Progress</span>
                                        <span>{course.progress}%</span>
                                    </div>

                                    <div className="w-full bg-gray-200 h-2 rounded">
                                        <div
                                            className="bg-blue-500 h-2 rounded"
                                            style={{
                                                width: `${course.progress}%`,
                                            }}
                                        />
                                    </div>
                                </div>

                                <Button
                                    className="w-full bg-amber-400 hover:bg-amber-300"
                                    onClick={() =>
                                        router.get(
                                            route(
                                                "student.course.show",
                                                course.id
                                            )
                                        )
                                    }
                                >
                                    Continue Learning
                                </Button>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </>
    )
}

