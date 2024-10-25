namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();

        return [
            'status' => 200,
            'message' => 'Usuários encontrados!',
            'users' => $users
        ];
    }

    public function me()
    {
        $user = $this->userService->getCurrentUser();

        return [
            'status' => 200,
            'message' => 'Usuário logado!',
            'usuario' => $user
        ];
    }

    public function store(UserCreateRequest $request)
    {
        $user = $this->userService->createUser($request->all());

        return [
            'status' => 200,
            'message' => 'Usuário cadastrado com sucesso!',
            'user' => $user
        ];
    }

    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado!',
            ];
        }

        return [
            'status' => 200,
            'message' => 'Usuário encontrado com sucesso!',
            'user' => $user
        ];
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado!',
            ];
        }

        $user = $this->userService->updateUser($user, $request->all());

        return [
            'status' => 200,
            'message' => 'Usuário atualizado com sucesso!',
            'user' => $user
        ];
    }

    public function destroy(string $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado!',
            ];
        }

        $this->userService->deleteUser($user);

        return [
            'status' => 200,
            'message' => 'Usuário deletado com sucesso!'
        ];
    }
}
