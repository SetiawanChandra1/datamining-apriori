import Authenticated from "@/Layouts/Authenticated/Index";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import FlashMessage from "@/Components/FlashMessage";
import { Head, Link, useForm } from "@inertiajs/inertia-react";
import { useState } from "react";
import NavLink from "@/Components/NavLink";

export default function Index({ auth, flashMessage, importedData }) {
    const {
        delete: destroy,
        setData,
        post,
        processing,
        errors,
    } = useForm({
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

    //Function for dropdown limit show data max 10
    const [limit, setLimit] = useState(10);

    const handleLimitChange = (event) => {
        const selectedValue = parseInt(event.target.value);
        if (selectedValue === -1) {
            setLimit(importedData.count);
        } else {
            setLimit(selectedValue);
        }
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
                    variant="primary"
                    processing={processing}
                >
                    Import
                </PrimaryButton>
            </form>
            <div className="mt-8">
                <h1>Show Data :</h1>
                <select
                    className="w-1/10"
                    value={limit}
                    onChange={handleLimitChange}
                >
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="-1">All Data</option>
                </select>
            </div>
            <table className="table-fixed w-full text-center mt-4">
                <thead>
                    <tr>
                        <th className="w-10">No</th>
                        <th className="w-2/12">Code Transaction</th>
                        <th>Date</th>
                        <th>Variant</th>
                        <th colSpan="2" className="w-3/12">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {importedData.slice(0, limit).map((transaction) => (
                        <tr key={transaction.id}>
                            <td>{transaction.id}</td>
                            <td>{transaction.code_transactions}</td>
                            <td>{transaction.date}</td>
                            <td>{transaction.variant}</td>
                            <td>
                                <Link
                                    href={route(
                                        "user.dashboard.transactions.edit",
                                        transaction.id
                                    )}
                                >
                                    <PrimaryButton
                                        type="button"
                                        variant="warning"
                                    >
                                        Edit
                                    </PrimaryButton>
                                </Link>
                            </td>
                            <td>
                                <div
                                    onClick={() => {
                                        destroy(
                                            route(
                                                "user.dashboard.transactions.destroy",
                                                transaction.id
                                            )
                                        );
                                    }}
                                >
                                    <PrimaryButton
                                        type="button"
                                        variant="danger"
                                    >
                                        Delete
                                    </PrimaryButton>
                                </div>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </Authenticated>
    );
}
