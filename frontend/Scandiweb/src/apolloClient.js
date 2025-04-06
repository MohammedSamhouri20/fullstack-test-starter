import { ApolloClient, InMemoryCache, HttpLink } from "@apollo/client";

const client = new ApolloClient({
  link: new HttpLink({
    uri: import.meta.env.VITE_API_URL,
    credentials: "include", // Match backend's Access-Control-Allow-Credentials: true
  }),
  cache: new InMemoryCache(),
});

export default client;
