# Laravel Blog API

This Laravel Blog API allows users to create, update, and manage blog posts. If a user doesn't provide a description for a post, the API uses **Gemini** to automatically generate one.

## Features

- **Create Posts:** Users can create new blog posts with a title, body, and optional description.
- **Update Posts:** Existing posts can be updated with new content.
- **Auto-Generated Descriptions:** If a description is not provided, Gemini generates one based on the post's content.
- **HTML Body:** The body of each post is stored in HTML format.
- **Comments on Posts:** Users can add comments to blog posts, fostering interaction and discussion.
- **Multiple Categories:** Posts can be assigned to multiple categories, allowing for better organization and filtering.

## Technologies Used

- **Laravel:** The primary PHP framework used for this API.
- **Gemini:** An AI tool used to generate descriptions for blog posts.
- **MySQL:** The database system used to store blog posts and comments.

## Installation

To install and run this project locally:

1. Clone the repository:

    ```bash
    git clone https://github.com/marwanzayed16/blog.git
    ```

2. Navigate to the project directory:

    ```bash
    cd blog
    ```

3. Install the dependencies:

    ```bash
    composer install
    ```

4. Set up your environment variables by copying the `.env.example` to `.env` and modifying it to suit your needs:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Run the database migrations:

    ```bash
    php artisan migrate
    ```

7. Serve the application:

    ```bash
    php artisan serve
    ```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open source and available under the [MIT License](LICENSE).
