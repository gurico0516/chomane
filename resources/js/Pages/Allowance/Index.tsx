import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { PageProps } from '@/types';

interface Allowance {
    allowance: string;
}

export default function Index({ auth, allowance }: PageProps<{ allowance?: Allowance }>) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className = "font-semibold text-xl text-gray-800 leading-tight">お小遣い</h2>}
        >
            <Head title="Allowance" />

            <div className="bg-white shadow-sm sm:rounded-lg mb-10">
                <button className="bg-gray-700 w-full text-white text-4xl px-4 py-2">
                    {allowance?.allowance}円
                </button>
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
        </AuthenticatedLayout>
    );
}
