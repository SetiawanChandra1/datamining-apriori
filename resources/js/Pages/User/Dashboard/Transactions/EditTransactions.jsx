import Authenticated from "@/Layouts/Authenticated/Index";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import Checkbox from "@/Components/Checkbox";
import PrimaryButton from "@/Components/PrimaryButton";
import { Head, useForm } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";

export default function Create({ auth, TransactionsModel }) {
    const { data, setData, processing, errors } = useForm({
        ...TransactionsModel,
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
        // if (data.thumbnail === movie.thumbnail) {
        //     delete data.thumbnail;
        // }

        Inertia.post(
            route("user.dashboard.transactions.update", TransactionsModel.id),
            {
                _method: "PUT",
                ...data,
            }
        );
    };
    return (
        <Authenticated auth={auth}>
            <Head title="User - Update Data" />
            <h1 className="text-xl mb-4">
                Update Data: {TransactionsModel.id}
            </h1>
            <hr className="mb4" />
            <form onSubmit={submit}>
                <InputLabel forInput="name" value="Code Transactions:" />
                <TextInput
                    type="text"
                    name="name"
                    defaultValue={TransactionsModel.code_transactions}
                    variant="primary-outline"
                    handleChange={onHandleChange}
                    placeholder="Enter the name of the movie"
                    isError={errors.code_transactions}
                />
                <InputError
                    message={errors.code_transactions}
                    className="mt-2"
                />
            </form>
        </Authenticated>
    );
}
