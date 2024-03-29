import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import { FormEventHandler } from 'react';
import { PageProps } from '@/types';

export default function CreateAllownceInformation({
    status,
    className = ''
}: {
    status?: string,
    className?: string
}) {
    const allowance = usePage<PageProps>().props.allowance;

    const { setData, patch, errors, processing, recentlySuccessful } = useForm({
        allowance: allowance,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        patch(route('allowance.create'));
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">お小遣い記録</h2>

                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    あなたの今週のお小遣いを入力してください。
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel htmlFor="allowance" value="お小遣い" />

                    <TextInput
                        id="allowance"
                        type="text"
                        pattern="^\d*$"
                        className="mt-1 block w-full"
                        onChange={(e) => {
                            if (/^\d*$/.test(e.target.value)) {
                                setData('allowance', e.target.value);
                            }
                        }}
                        required
                    />

                    <InputError className="mt-2" message={errors.allowance} />
                </div>

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>記録</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enterFrom="opacity-0"
                        leaveTo="opacity-0"
                        className="transition ease-in-out"
                    >
                        <p className="text-sm text-gray-600 dark:text-gray-400">記録完了</p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
