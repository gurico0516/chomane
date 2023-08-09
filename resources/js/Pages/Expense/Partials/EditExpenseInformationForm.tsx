import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import SelectInput from "@/Components/SelectInput";
import { Link, useForm, usePage } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import { FormEventHandler } from 'react';
import { PageProps } from '@/types';

type ExpenseObjectType = {
    id?: number;
    expense?: string;
    memo?: string;
    type?: string;
};

export default function EditExpenseInformation({ status, className = '' }: { status?: string, className?: string }) {
    const expenseObject = usePage<PageProps<{ expense: ExpenseObjectType }>>().props.expense;

    const { data, setData, post, errors, processing, recentlySuccessful } = useForm({
        expense: expenseObject?.expense,
        memo: expenseObject?.memo,
        type: expenseObject?.type,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('expense.edit', { expenseId: expenseObject?.id || expenseObject?.expenseId }));

    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                    支出記録
                </h2>

                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    あなたの支出を入力してください。
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel htmlFor="expense" value="支出" />

                    <TextInput
                        id="expense"
                        className="mt-1 block w-full"
                        value={data.expense}
                        onChange={(e) => setData("expense", e.target.value)}
                        required
                    />

                    <InputError className="mt-2" message={errors.expense} />
                </div>

                <div>
                    <InputLabel htmlFor="memo" value="メモ" />

                    <TextInput
                        id="memo"
                        value={data.memo}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("memo", e.target.value)}
                    />

                    <InputError className="mt-2" message={errors.memo} />
                </div>

                <div>
                    <InputLabel htmlFor="type" value="タイプ" />

                    <SelectInput
                        id="type"
                        value={data.type}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("type", e.target.value)}
                        required
                    >
                        <option value="">選択してください</option>
                        <option value="1">雑費</option>
                        <option value="2">食費</option>
                        <option value="3">消耗費</option>
                        <option value="4">交際費</option>
                    </SelectInput>

                    <InputError className="mt-2" message={errors.type} />
                </div>

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>記録</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enterFrom="opacity-0"
                        leaveTo="opacity-0"
                        className="transition ease-in-out"
                    >
                        <p className="text-sm text-gray-600 dark:text-gray-400">
                            記録完了
                        </p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
