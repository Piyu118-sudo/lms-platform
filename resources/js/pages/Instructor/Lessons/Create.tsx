import { Head, useForm } from '@inertiajs/react'
import { router } from '@inertiajs/react'
import route from 'ziggy-js'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import React from 'react'

interface Props {
    course: {
        id: number
        title: string
        lessons: {
            id: number
            title: string
            duration: number
        }[]
    }
}

export default function Create({ course }: Props) {

    const { data, setData, post, processing, errors } = useForm({
        title: '',
        content: '',
        video_url: '',
        duration: '',
        is_preview: false,
    })

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault()
        post(route('instructor.lessons.store', course.id))
    }

    return (
        <>
            <Head title="Add Lesson" />

            <div className="max-w-2xl mx-auto p-6">
                <h1 className="text-2xl font-bold mb-6">
                    Add Lesson to {course.title}
                </h1>

                <form onSubmit={submit} className="space-y-5">

                    <Input
                        placeholder="Lesson title"
                        value={data.title}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) =>
                            setData('title', e.target.value)
                        }
                    />
                    {errors.title && (
                        <p className="text-red-500 text-sm">
                            {errors.title}
                        </p>
                    )}

                    <Textarea
                        placeholder="Lesson Content"
                        value={data.content}
                        onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) =>
                            setData('content', e.target.value)
                        }
                    />

                    <Input
                        type="number"
                        placeholder="Duration (minutes)"
                        value={data.duration}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) =>
                            setData('duration', e.target.value)
                        }
                    />

                    <Input
                        placeholder="Video URL"
                        value={data.video_url}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) =>
                            setData('video_url', e.target.value)
                        }
                    />

                    <Button type="submit" disabled={processing}>
                        {processing ? 'Creating...' : 'Create Lesson'}
                    </Button>
                </form>

                {/* LESSON LIST */}
                <div className="mt-10">
                    <div className="flex items-center justify-between mb-4">
                        <h2 className="text-xl font-semibold">
                            Course Lessons
                        </h2>

                        <Button
                            onClick={() =>
                                router.get(
                                    route('instructor.lessons.create', course.id)
                                )
                            }
                        >
                            Add Lesson
                        </Button>
                    </div>

                    {course.lessons.length === 0 && (
                        <p className="text-muted-foreground">
                            No lessons found.
                        </p>
                    )}

                    <div className="space-y-3">
                        {course.lessons.map((lesson, index) => (
                            <div
                                key={lesson.id}
                                className="flex justify-between items-center p-4 border rounded-lg"
                            >
                                <div>
                                    <p className="font-medium">
                                        {index + 1}. {lesson.title}
                                    </p>
                                    <p className="text-sm text-muted-foreground">
                                        {lesson.duration ?? 0} mins
                                    </p>
                                </div>

                                <Button
                                    variant="destructive"
                                    size="sm"
                                    onClick={() => {
                                        if (confirm('Delete this lesson?')) {
                                            router.delete(
                                                route(
                                                    'instructor.lessons.destroy',
                                                    lesson.id
                                                )
                                            )
                                        }
                                    }}
                                >
                                    Delete
                                </Button>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </>
    )
}


