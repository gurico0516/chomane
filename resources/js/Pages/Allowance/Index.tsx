import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { PageProps } from '@/types';

interface Allowance {
    id: number;
    allowance: string;
    user_id: number;
}


export default function Index({ auth, allowance }: PageProps<{ allowance?: Allowance }>) {
    console.log(allowance.user_id);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className = "font-semibold text-xl text-gray-800 leading-tight">お小遣い</h2>}
        >
            <Head title="Allowance" />

            <div className="bg-white shadow-sm sm:rounded-lg mb-10">
                <Link href={route('allowance.edit', allowance?.user_id)}>
                    <button className="bg-gray-700 w-full text-white text-4xl px-4 py-2">
                        {allowance?.allowance}円
                    </button>
                </Link>
                <div className="flex">
                    <label className="rounded flex-auto w-64 bg-green-400 text-white m-1 p-1 text-center">
                        <Link href={route('allowance.create')}>
                            <button>お小遣い記録</button>
                        </Link>
                    </label>
                    <label className="rounded flex-auto w-64 bg-blue-400 text-white m-1 p-1 text-center">
                        <a href="{{ route('balances.create') }}">
                            <button>支出の記録</button>
                        </a>
                    </label>
                </div>
            </div>

            <div className="bg-white shadow-sm sm:rounded-lg">
                <div className="p-6 border-b border-gray-200 flex items-center justify-between">
                    <div className="flex flex-col">
                        <span className="text-2xl text-gray-800"></span>
                    </div>
                    <a href="{{ route('balances.show', $balance->id) }}">
                        <p className="text-xl"></p>
                        <p className="text-xl"></p>
                        <p className="text-xl"></p>
                    </a>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
