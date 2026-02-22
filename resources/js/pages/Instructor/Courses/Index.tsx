import { Head, Link } from "@inertiajs/react";
import type { Course } from "./types";


interface Props {
    courses: Course[];
}

export default function Index({ courses }: Props) {
    return (
        <>
            <Head title="My Courses" />

            <div className="p-6">
                <div className="flex items-center justify-between mb-6">
                    <h1 className="text-2xl font-bold">My Courses</h1>

                    <Link
                        href={route("instructor.courses.create")}
                        className="bg-black text-white px-4 py-2 rounded"
                    >
                        Create Course
                    </Link>
                </div>

                <div className="space-y-4">
                    {courses.map((course) => (
                        <div
                            key={course.id}
                            className="border p-4 rounded-lg"
                        >
                            <h2 className="text-lg font-semibold">
                                {course.title}
                            </h2>

                            <p className="text-sm text-gray-500">
                                Level: {course.level}
                            </p>

                            <p className="mt-2">
                                ${course.price}
                            </p>
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
}

