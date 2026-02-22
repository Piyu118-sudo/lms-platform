import { Head, useForm } from '@inertiajs/react'
import { useState } from 'react'
import route from 'ziggy-js'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import type { Category } from '@/pages/Instructor/Courses/types'
import { Textarea } from '@/components/ui/textarea'

interface Props {
    categories: Category[]
}

export default function Create({ categories }: Props) {

    const { data, setData, post, processing, errors } =
        useForm({
            title: '',
            description: '',
            price: '',
            level: '',
            category_id: '',
            thumbnail: null as File | null,
        })

    const [preview, setPreview] = useState<string | null>(null)

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault()

        post(route('instructor.courses.store'), {
            forceFormData: true,
        })
    }

    return (
        <>
            <Head title="Create Courses" />

            <div className="max-w-2xl mx-auto p-6">
                <h1 className="text-2xl font-bold mb-6">
                    Create New Course
                </h1>

                <form onSubmit={submit} className="space-y-6">

                    <Input
                        placeholder="Course title"
                        value={data.title}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) =>
                            setData('title', e.target.value)
                        }
                    />

                    <Textarea
                        placeholder="Course description"
                        value={data.description}
                        onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) =>
                            setData('description', e.target.value)
                        }
                    />

                    <Input
                        type="number"
                        placeholder="Course price"
                        value={data.price}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) =>
                            setData('price', e.target.value)
                        }
                    />

                    <Select
                        value={data.level}
                        onValueChange={(value) =>
                            setData('level', value)
                        }
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Select Level" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem value="beginner">Beginner</SelectItem>
                            <SelectItem value="intermediate">Intermediate</SelectItem>
                            <SelectItem value="advanced">Advanced</SelectItem>
                        </SelectContent>
                    </Select>

                    <Select
                        value={data.category_id}
                        onValueChange={(value) =>
                            setData('category_id', value)
                        }
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Select Category" />
                        </SelectTrigger>

                        <SelectContent>
                            {categories.map((category) => (
                                <SelectItem
                                    key={category.id}
                                    value={String(category.id)}
                                >
                                    {category.name}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>

                    <Input
                        type="file"
                        accept="image/*"
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) => {
                            const file = e.target.files?.[0] || null
                            setData('thumbnail', file)

                            if (file) {
                                setPreview(URL.createObjectURL(file))
                            }
                        }}
                    />

                    {preview && (
                        <img
                            src={preview}
                            className="w-48 h-32 object-cover rounded-lg"
                        />
                    )}

                    <Button
                        type="submit"
                        disabled={processing}
                        className="w-full"
                    >
                        {processing ? 'Processing...' : 'Create Course'}
                    </Button>

                </form>
            </div>
        </>
    )
}



