import React, { useEffect } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/inertia-react";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    useEffect(() => {
        return () => {
            reset("password", "password_confirmation");
        };
    }, []);

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();

        post(route("register"));
    };

    return (
        <>
            <Head>
                <title>Sign Up</title>
            </Head>

            <div className="mx-auto max-w-screen min-h-screen bg-white text-black md:px-10 px-3">
                <div className="fixed top-[50px] left-[150px] hidden lg:block">
                    <img
                        src="/images/signup-image.png"
                        className="hidden laptopLg:block laptopLg:max-w-[400px] laptopXl:max-w-[400px]"
                        alt=""
                    />
                </div>
                <div className="py-12 flex laptopLg:ml-[580px] laptopXl:ml-[770px]">
                    <div>
                        <img src="/images/logo-brand.svg" alt="" />
                        <div className="my-[40px]">
                            <div className="font-semibold text-[26px] mb-3">
                                Sign Up
                            </div>
                        </div>
                        <form className="w-[370px]" onSubmit={submit}>
                            <div className="flex flex-col gap-6">
                                <div>
                                    <InputLabel forInput="name">
                                        Name
                                    </InputLabel>
                                    <TextInput
                                        type="text"
                                        name="name"
                                        value={data.name}
                                        placeholder="Your Name..."
                                        isFocused={true}
                                        handleChange={onHandleChange}
                                        required
                                    />

                                    <InputError
                                        message={errors.name}
                                        className="mt-2"
                                    />
                                </div>
                                <div>
                                    <InputLabel forInput="email">
                                        Email Address
                                    </InputLabel>
                                    <TextInput
                                        type="email"
                                        name="email"
                                        value={data.email}
                                        placeholder="Your Email Address"
                                        handleChange={onHandleChange}
                                        required
                                    />

                                    <InputError
                                        message={errors.email}
                                        className="mt-2"
                                    />
                                </div>
                                <div>
                                    <InputLabel forInput="password">
                                        Password
                                    </InputLabel>
                                    <TextInput
                                        type="password"
                                        name="password"
                                        value={data.password}
                                        placeholder="Your Password"
                                        handleChange={onHandleChange}
                                        required
                                    />

                                    <InputError
                                        message={errors.password}
                                        className="mt-2"
                                    />
                                </div>
                                <div>
                                    <InputLabel forInput="password_confirmation">
                                        Confirm Password
                                    </InputLabel>
                                    <TextInput
                                        type="password"
                                        name="password_confirmation"
                                        value={data.password_confirmation}
                                        placeholder="Your Password"
                                        handleChange={onHandleChange}
                                        required
                                    />

                                    <InputError
                                        message={errors.password_confirmation}
                                        className="mt-2"
                                    />
                                </div>
                            </div>
                            <div className="grid space-y-[14px] mt-[30px]">
                                <PrimaryButton processing={processing}>
                                    <span className="text-base font-semibold">
                                        Sign Up
                                    </span>
                                </PrimaryButton>
                                <Link href={route("login")}>
                                    <PrimaryButton
                                        type="button"
                                        variant="light-outline"
                                    >
                                        <span className="text-base text-black">
                                            Sign In to My Account
                                        </span>
                                    </PrimaryButton>
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </>
    );
}
