import Authenticated from "@/Layouts/Authenticated/Index";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import FlashMessage from "@/Components/FlashMessage";
import { Head, useForm } from "@inertiajs/inertia-react";

export default function Index({ auth, flashMessage }) {
    const { setData, post, processing, errors } = useForm({
        dataexcel: "",
    });

    const onHandleChange = (event) => {
        setData(
            event.target.name,
            event.target.type === "file"
                ? event.target.files[0]
                : event.target.value
        );
    };

    const submit = (e) => {
        e.preventDefault();

        post(route("user.dashboard.user.import"));
    };

    return (
        <Authenticated auth={auth}>
            <Head title="Transactions" />
            {flashMessage?.message && (
                <FlashMessage message={flashMessage.message} />
            )}
            <form onSubmit={submit}>
                <TextInput
                    type="file"
                    name="dataexcel"
                    variant="primary-outline"
                    handleChange={onHandleChange}
                    placeholder="Insert data excel of the movie"
                    isError={errors.dataexcel}
                />
                <InputError message={errors.dataexcel} className="mt-2" />
                <PrimaryButton
                    type="submit"
                    className="mt-4 w-2/12"
                    processing={processing}
                >
                    Import
                </PrimaryButton>
            </form>
        </Authenticated>
    );
}
